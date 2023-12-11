{-# LANGUAGE LambdaCase #-}
module JSON (
    JSON(..),
    -- | get key from json object if it exists
    (%),
    -- | get nth element from json list if it exists
    (//),
    -- | get Integer from json number if it is an integer
    int,
    -- | get Rational from json number
    rat,
    -- | get String from json string
    str,
    -- | get [JSON] from json array
    list,
    -- | get unit from json null if it exists
    JSON.null,
    -- | returns true if field is null
    JSON.isNull,
    -- | describes the type of the json object as "json {type}"
    pretty,
    JSONVal(..),
    JSONState(..),
    runJSON,
    runJSON_,
    setProp,
    getProp,
    push,
    emptyJSON,
    emptyJSONList,
    self
) where

import qualified JsonParse as J
import qualified Data.Map as M
import Text.Read (readPrec)
import Control.Monad.RWS (MonadWriter(tell))
import Data.Foldable (sequenceA_)
import Data.List (intercalate)
import Data.Graph (Tree)
import Data.Tree (unfoldTree, drawTree)
import Control.Applicative (Alternative(empty, (<|>)))
import qualified Control.Monad.State.Strict as S
import qualified Control.Monad.Writer.Strict as W
import Data.Bifunctor (Bifunctor(second, first))
import Control.Monad ((>=>))
import GHC.IO (unsafePerformIO)

--This module provides a JSON data structure and a Read instance for the data structure.
--This module also provides operations for pulling data out the structure.
--Internally this works by reading an abstract syntax tree first, then converting
--the abstract syntax tree into a useable JSON data structure.
class JSONVal a where
    json :: a -> JSON
    value :: Alternative f => JSON -> f a
data JSON =
    JSONObject (M.Map String JSON) |
    JSONArray [JSON] |
    JSONString String |
    JSONNumber Double |
    JSONBool Bool |
    JSONNull

assocs (J.MemberSingle (J.Member _ k _ (J.Element _ v _))) = [(k, convertValue v)]
assocs (J.Members (J.Member _ k _ (J.Element _ v _)) xs) = (k,convertValue v):assocs xs
toList (J.ElementSingle (J.Element _ x _)) = [convertValue x]
toList (J.Elements (J.Element _ x _) xs) = convertValue x:toList xs
digToChar (J.Digit (J.OneNine x)) = x
digToChar J.Zero = '0'
hexToChar (J.Hex x) = x
hexToChar (J.HexDigit x) = digToChar x
toString J.CharactersEmpty = []
toString (J.Characters x xs) = case x of
    (J.Character c) -> c:toString xs
    (J.CharacterEscape c) -> case c of
        (J.Escape v) -> v:toString xs
        (J.EscapeHex a b c d) -> read ['\'',hexToChar a,hexToChar b,hexToChar c,hexToChar d]:toString xs
digToString (J.Digits x xs) = digToChar x:digToString xs
digToString (J.OneDigit x) = [digToChar x]
digToInteger :: J.Digits -> Integer
digToInteger x = read (digToString x)
convertInt (J.JIntegerSingle d) = read [digToChar d]
convertInt (J.JIntegerSingleSigned d) = -1 * read [digToChar d]
convertInt (J.JInteger (J.OneNine d) ds) = read (d:digToString ds)
convertInt (J.JIntegerSigned (J.OneNine d) ds) = -1 * read (d:digToString ds)
signToInt J.NoSign = 1; signToInt J.Positive = 1; signToInt J.Negative = -1;

convertValue :: J.Value -> JSON
convertValue (J.ValueObject (J.ObjectEmpty _)) = JSONObject M.empty
convertValue (J.ValueObject (J.Object x)) = JSONObject (M.fromList (fmap (\(J.JString x, k) -> (toString x, k)) (assocs x)))
convertValue (J.ValueArray (J.ArrayEmpty _)) = JSONArray []
convertValue (J.ValueArray (J.Array x)) = JSONArray (toList x)
convertValue (J.ValueString (J.JString x)) = JSONString (toString x)
convertValue (J.ValueNumber (J.JNumber w J.FractionEmpty J.ExponentEmpty)) = JSONNumber (fromInteger (convertInt w))
convertValue (J.ValueNumber (J.JNumber w (J.Fraction f) J.ExponentEmpty)) = 
    JSONNumber (read (show (convertInt w)++'.':digToString f)) where
    
convertValue (J.ValueNumber (J.JNumber w (J.Fraction f) (J.Exponent _ s m))) = 
    JSONNumber (read (show (convertInt w)++'.':digToString f))
convertValue (J.ValueLiteral "true") = JSONBool True
convertValue (J.ValueLiteral "false") = JSONBool False
convertValue (J.ValueLiteral "null") = JSONNull


convertParsed :: J.JSON -> JSON
convertParsed (J.JSON (J.Element _ v _)) = convertValue v

instance Read JSON where readPrec = convertParsed <$> readPrec

emptyJSON = JSONObject M.empty
emptyJSONList = JSONArray []

toTree :: JSON -> Tree String
toTree = unfoldTree f where
    f = \case
        (JSONObject m) -> ("{}", fmap (\(k, v) -> JSONArray [JSONString k, v]) (M.assocs m))
        (JSONArray m) -> ("[]", m)
        (JSONString s) -> (s, [])
        (JSONNumber n) -> (show n, [])
        (JSONBool b) -> (if b then "true" else "false", [])
        JSONNull -> ("null",[])

(%) :: (JSONVal v, Alternative f) => JSON -> String -> f v
(JSONObject m) % str = maybe empty value (M.lookup str m)
_              % _   = empty
(JSONArray l) // idx = f idx l where
    f 0 (x:xs) = value x
    f n (x:xs) = f (n - 1) xs
    f n []     = empty
_             // _   = empty
int (JSONNumber x) = if fromInteger (truncate x) /= x
    then empty
    else pure (truncate x)
int _              = empty
rat (JSONNumber x) = pure x
rat _              = empty
str (JSONString s) = pure s
str _              = empty
bool (JSONBool b) = pure b
bool _            = empty
null JSONNull = pure ()
null _        = empty
list (JSONArray l) = pure l
list _             = empty

self :: Applicative f => JSON -> f JSON
self = pure

isNull JSONNull = True
isNull _        = False
pretty (JSONObject _) = "json object"
pretty (JSONArray _) = "json array"
pretty (JSONString _) = "json string"
pretty (JSONNumber _) = "json number"
pretty (JSONBool _) = "json boolean"
pretty JSONNull = "json null"

hoistMaybe (Just x) = pure x; hoistMaybe Nothing = empty
setProp key val = S.get >>= \case
    (JSONObject p) -> S.put (JSONObject (M.insert key (json val) p))
    x              -> empty
getProp key = S.get >>= \case
    (JSONObject p) -> hoistMaybe (M.lookup key p >>= value)
    _              -> empty
push val = S.get >>= \case
    (JSONArray a) -> S.put (JSONArray (json val:a))
    x             -> empty

debug x = seq
    (unsafePerformIO (print x))
    pure x
instance JSONVal JSON where
    json = id
    value = pure
instance JSONVal (M.Map String JSON) where
    json = JSONObject
    value (JSONObject x) = pure x
    value  _             = empty
instance JSONVal String where
    json = JSONString
    value (JSONString x) = pure x
    value  _             = empty
instance JSONVal Integer where
    json = JSONNumber . fromInteger
    value (JSONNumber x) = if fromInteger (truncate x) /= x then empty else pure (truncate x)
    value  _             = empty
instance JSONVal Double where
    json = JSONNumber
    value (JSONNumber x) = pure x
    value  _             = empty
instance JSONVal Bool where
    json = JSONBool
    value (JSONBool x) = pure x
    value  _           = empty
instance JSONVal () where
    json _ = JSONNull
    value JSONNull = pure ()
    value _        = empty

newtype JSONState a = JSONState (forall f. (Monad f, Alternative f) => (JSON -> f (a, JSON)))
instance Functor JSONState where
    fmap f (JSONState g) = JSONState (fmap (first f) . g)
instance Applicative JSONState where
    pure x = JSONState (\s -> pure (x, s))
    f <*> x = f >>= \f -> x >>= \x -> pure (f x)
instance Alternative JSONState where
    empty = JSONState (const empty)
    (JSONState f) <|> (JSONState g) = JSONState (\j -> f j <|> g j)
instance S.MonadState JSON JSONState where
    get = JSONState (\s -> pure (s, s))
    put x = JSONState (const (pure ((), x)))
instance Monad JSONState where
    (JSONState x) >>= kleisli = JSONState (x >=> \(x, j) -> let (JSONState y) = kleisli x in y j)
isPoint (JSONArray [JSONNumber x, JSONNumber y]) = True; isPoint _ = False
instance Show JSON where
    show (JSONObject p) = case M.size p of
        0 -> "{}"
        x -> "{\n"++indent (intercalate ",\n" (fmap (\(k,v) -> show k++':':show v) (M.assocs p)))++"\n}"
    show (JSONArray a) = case length a of
            0 -> "[]"
            x -> if and (fmap isPoint a) || isPoint (JSONArray a)
                then '[':intercalate "," (fmap show a)++"]"
                else "[\n"++indent (intercalate ",\n" (fmap show a))++"\n]"
    show (JSONString s) = show s
    show (JSONNumber x)
        | fromInteger (truncate x) == x = show (truncate x)
        | otherwise = show x
    show (JSONBool True) = "true"; show (JSONBool False) = "false"
    show JSONNull = "null"            

splitAt' x = getSlices where
    getSlice (y:ys) = if y == x then ([y], ys) else first (y:) (getSlice ys)
    getSlice [] = ([], [])
    getSlices lst = case getSlice lst of
        ([], []) -> []
        ( x, []) -> [x]
        ( x,  y) -> x:getSlices y
indent x = splitAt' '\n' x >>= ('\t':)

runJSON j (JSONState s) = s j
runJSON_ j (JSONState s) = s j >>= \(_, x) -> pure x