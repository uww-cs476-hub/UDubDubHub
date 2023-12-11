{-# LANGUAGE LambdaCase #-}
{-# OPTIONS_GHC -Wno-unrecognised-pragmas #-}
module Main (main) where
{-
Sorry for writing this in Haskell.
-}
import Data.Map.Strict (Map, fromList, assocs)
import qualified Data.Map.Strict as M
import Control.Applicative (Alternative(many, (<|>), empty))
import Data.Char (isSpace, isAlphaNum)
import SimpleParse (Parser(..), Parse(..), munch, char, string, get, manyTill, (<++))
-- import GHC.IO (unsafePerformIO) --no purity LMAO
import Data.Maybe (fromMaybe, catMaybes, isJust, mapMaybe)
import Data.IntMap.Strict (IntMap)
import qualified Data.IntMap.Strict as I
import qualified Data.Set as S
-- import qualified Control.Monad.State.Strict as ST 
import qualified Data.Text as T
import Data.Functor (($>))
import Control.Monad.RWS (MonadWriter(tell))
import GHC.Stack (HasCallStack)
import System.Environment (getArgs)
import System.Directory (doesFileExist)
import Control.Exception (try, SomeException)
import Data.ByteString.Char8 (hPutStrLn, pack)
import GHC.IO.StdHandles (stderr)
import Control.Monad.Trans.Maybe (MaybeT (runMaybeT, MaybeT))
import Control.Monad.Cont (liftIO, (>=>))
import Control.Arrow ((&&&), (>>>), Arrow (first, second))
import Data.Foldable (sequenceA_, traverse_)
import JSON (JSON (JSONObject, JSONString, JSONArray), pretty, (%), str, list, runJSON, emptyJSON, runJSON_, setProp, self, emptyJSONList, push, JSONVal (json))
import Data.List (intersperse)
import Control.Monad (unless)

data XMLTag = XMLTag String (Map String String) [XMLTag]
data WayTagTmp =
    WayTagBoxed Int String Poly                 | 
    WayPoly     Int Poly                        | 
    WayRef      Int Int    String deriving Show
data WayTag = WayTag Int String [Poly] deriving Show
type NodeDB = (IntMap (String, String))
type WayDB = (Map String WayTag)
type Poly = [(String, String)]

data AssertXML = String := String
(&) :: (Monad f, Alternative f) => 
    XMLTag -> String -> f String
(XMLTag _ p _) & s = maybe empty pure (M.lookup s p)
(?) :: (Monad f, Alternative f) =>
    XMLTag -> AssertXML -> f ()
x ? (property := value) = 
    x&property >>=
    \result -> unless (result == value) empty
(??) :: (Monad f, Alternative f) =>
    XMLTag -> String -> f ()
(XMLTag name _ _) ?? expected = unless (name == expected) empty

infixl 9 :=
infixr 5 ?
instance Parse XMLTag where
    parser = (readMeta <++ pure ()) *> readXML where
        sks = munch isSpace
        readXML = (sks <* char '<' *> munch isAlphaNum) >>=
            \name -> XMLTag name <$> readProperties <*> readChildren name
        readChildren name = ((sks <* string "/>") $> []) <++ (
            (sks <* char '>') *> many parser <* 
            (sks <* string "</" <* sks <* string name <* sks <* char '>'))
        readProperty = 
            (sks *> ((,) <$> munch isAlphaNum <* sks <* char '=' <* sks)) <*>
            (char '"' *> manyTill get (char '"'))
        readProperties = fromList <$> many readProperty
        readMeta = (sks <* string "<?" <* manyTill get (string "?>")) $> ()
--create a node "database", then create a Way "database" using the node "database"
nodeDB' children = I.fromList (mapMaybe readEntry children) where
    readEntry (XMLTag _ p _) = (,) . read <$> M.lookup "id" p <*> 
        ((,) <$> M.lookup "lat" p <*> M.lookup "lon" p)
wayDB (XMLTag "osm" _ children) = makeDB ways' where
    node = nodeDB' children
    poly = mapMaybe (
        \x -> x??"nd" *> fmap ((node I.!) . read) (x&"ref"))
    name c = case mapMaybe (\x -> x?"k":="name" *> x&"v") c of
        (x:xs) -> pure x
        _      -> empty
    way' x@(XMLTag "way" p c) = 
        (WayTagBoxed . read <$> 
            x&"id" <*>
            name c <*>
            pure (poly c)) <|>
        (WayPoly . read <$>
            x&"id" <*>
            pure (poly c))
    way' x@(XMLTag "relation" p ((XMLTag "member" p' c'):xs)) = 
        WayRef . read <$> 
            x&"id" <*> 
            fmap read (M.lookup "ref" p') <*>
            name xs
    way' _ = Nothing    
    ways' = mapMaybe way' children
    poly' = I.fromList (mapMaybe (\case
        (WayPoly i p) -> pure (i, p)
        _             -> empty) ways')
    makeDB [] = M.empty
    makeDB (WayTagBoxed i n p:xs) = M.insertWith
        (\(WayTag i1 n1 p1) (WayTag i2 n2 p2) -> WayTag i1 n1$ p1 ++ p2)
        n (WayTag i n [p])$ makeDB xs
    makeDB (WayRef i r n:xs) = M.insertWith
        (\(WayTag i1 n1 p1) (WayTag i2 n2 p2) -> WayTag i1 n1$ p1 ++ p2)
        n (WayTag i n [poly' I.! r])$ makeDB xs
    makeDB (WayPoly _ _:xs) = makeDB xs
    
--we are building a JSON file from XML data
compile wayDB config = runJSON_ emptyJSON (
    ((config%"imagesRoot") <|> pure ".\\") >>= \imgRoot -> let
        moveStr g s1 s2 = g%s1 >>= str >>= setProp s2
        moveStr' g s1 s2 s3 = ((g%s1) <|> pure s2) >>= setProp s3
        moveStr'' g s1 s2 s3 s4 =
            ((g%s1) <|> pure s2) >>= setProp s3 . (s4 ++)
        moveJson g s1 s2 = g%s1 >>= self >>= setProp s2
        moveMembers g s1 s2 = 
            g%s1 >>=
            list >>=
            runJSON_ emptyJSONList . traverse generateMember >>=
            setProp s2
        movePolys g s1 s2 =
            g%s1 >>= createPolys >>= setProp s2
        moveGroups g s1 s2 = 
            g%s1 >>= 
            list >>= 
            runJSON_ emptyJSONList . traverse generateGroup >>=
            setProp s2
        generateGroup g = runJSON_ emptyJSON (
            moveStr g "groupName" "name" *>
            moveJson g "style" "style" *>
            moveJson g "selectedStyle" "selectedStyle" *>
            moveMembers g "queries" "members") >>= push
        generateMember g = runJSON_ emptyJSON (
            moveStr g "name" "name" *>
            moveStr' g "addr" "NO ADDRESS PROVIDED" "addr" *>
            moveStr'' g "img" "default.jpg" "img" imgRoot *>
            movePolys g "wayName" "polys") >>= push
    in moveGroups config "groups" "groups") where
    createPolys wayName = maybe empty pure (M.lookup wayName wayDB) >>=
        \(WayTag _ _ p) -> runJSON_ emptyJSONList (traverse createPoly p)
    createPoly p = runJSON_ emptyJSONList (traverse createPoint p) >>= push
    createPoint (lat, lon) = 
        push (JSONArray [json (read lat::Double), json (read lon::Double)])
x ~> y = \z -> if z == x then y else z

main = runMaybeT (
    readConfig >>= 
    \(jobs, wayText) -> readOSM wayText >>= 
    \wayDB -> generateJSON wayDB jobs) $> () where

    putErrLn x = putStrLn ("\ESC[31m"++x++"\ESC[0m")
    readConfig =
        liftIO getArgs >>=
        \args -> let
            configPath = if null args then ".\\config.json" else head args
        in (liftIO . try . readFile) configPath >>= (\case
            Left  (_ :: SomeException) ->
                (if null args
                    then liftIO$ putErrLn ("Failed to open configuration file at default location: \"" ++ configPath ++
                    "\" You may specify a path for the configuration file by supplying it as a command line argument. Good bye!")
                    else liftIO$ putErrLn ("Failed to open specified configuration file at: \"" ++ configPath ++ "\". Good bye!")) *> empty
            Right text                 -> pure (read text)) >>=
        \properties -> (case properties%"waySource"  of
            Just (JSONString x) -> pure x
            Just             x  -> (liftIO . putErrLn) ("Error! Expected a json string for \"waySource\", got an "++pretty x++" instead. Good bye!") *> empty
            Nothing             -> (liftIO . putErrLn) "Please provide the path of an .osm file under the property \"waySource\". Good bye!" *> empty) >>=
        \waySource -> pure (properties, waySource)
    readOSM waySource =
        (liftIO . try . fmap T.pack . forceRead) waySource >>= (\case
            Right               text  -> pure text
            Left (_ :: SomeException) -> (liftIO . putErrLn) ("Error! Unable to read map data at file path \""++waySource++"\". Good bye!") *> empty) >>=
        \wayText -> (liftIO . putStrLn) "Parsing map data as XML document..." *> (case parseT wayText of
            Just xml -> pure xml
            Nothing -> (liftIO . putStrLn) ("Error! Unable to parse the map data at file path\""++waySource++"\". Good bye!") *> empty) >>=
        \wayXML -> (liftIO . putStrLn) "Extracting polygon data from XML document..." $> wayDB wayXML
    generateJSON wayDB json = 
        runMaybeT (
            json%"jsonOut" >>= str >>=
            \fileName -> compile wayDB json >>= liftIO . writeFile fileName . show) >>= \case
                Just () -> (liftIO . putStrLn) "Successfully compiled JSON object."
                Nothing -> (liftIO . putErrLn) "Failed to compile JSON object."
    forceRead f = 
        readFile f >>=
        \s -> seq (length s) (pure s) 