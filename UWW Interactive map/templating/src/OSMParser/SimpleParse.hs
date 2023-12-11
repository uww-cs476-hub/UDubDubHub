{-# OPTIONS_GHC -Wno-unrecognised-pragmas #-}
{-# HLINT ignore "Replace case with maybe" #-}
module SimpleParse (Parse(..), Parser(..), munch, char, string, (<++), manyTill, get) where
import Control.Applicative (Alternative ((<|>), empty))
import Data.Bifunctor (Bifunctor(first))
import Control.Monad ((>=>))
import Data.List (isPrefixOf)
import Data.Functor (($>))
import Data.Text (Text)
import qualified Data.Text as T
import Data.String (fromString)

--------------------------------------------------------------------------------
class Parse a where
    parser :: Parser a
    parse :: forall f. (Monad f, Alternative f) => String -> f a
    parse s = let (P f) = parser in fmap fst (f (fromString s))
    parseT :: forall f. (Monad f, Alternative f) => Text -> f a
    parseT s = let (P f) = parser in fmap fst (f s)

newtype Parser a = P 
    (forall f. (Monad f, Alternative f) => Text -> f (a, Text))
instance Functor Parser where 
    fmap f (P p) = P (fmap (first f) . p)
instance Applicative Parser where
    pure x = P (\s -> pure (x, s))
    (P f) <*> (P x) = P (f >=> \(f, s) -> x s >>= \(y, s) -> pure (f y, s))
instance Monad Parser where 
    (P x) >>= kleisli = P (x >=> \(x, s) -> let (P y) = kleisli x in y s)
instance Alternative Parser where
    empty = P (const empty)
    (P a) <|> (P b) = P (\s -> a s <|> b s)

munch p = P g where
    g t = case T.uncons t of
        Just (x, xs) -> if p x
            then fmap (first (x:)) (g xs)
            else pure ([], t)
        Nothing -> pure ([], t)
char c = P (
    \t -> case T.uncons t of
        Nothing      -> empty
        Just (x, xs) -> if x == c
            then pure (c, xs)
            else empty)
string x = P (
    \s -> if fromString x `T.isPrefixOf` s
        then pure (x, T.drop (length x) s)
        else empty)
(P a) <++ (P b) = P (\t -> case a t of
    Nothing -> b t
    Just x  -> pure x)
manyTill f x = (x $> []) <++ ((:)<$>f<*>manyTill f x)
get = P (
    \t -> case T.uncons t of
        Nothing -> empty
        Just x  -> pure x)
