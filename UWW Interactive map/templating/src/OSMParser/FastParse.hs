{-# OPTIONS_GHC -Wno-unrecognised-pragmas #-}
{-# HLINT ignore "Avoid lambda" #-}
{-# HLINT ignore "Use >=>" #-}
{-# HLINT ignore "Use const" #-}
module FastParse where
import Data.Text (Text, uncons, isPrefixOf, drop)
import qualified Data.Text as T
import Control.Applicative (Alternative ((<|>), empty))
import Control.Monad ((>=>))
import Control.Arrow (first)
import Data.String (fromString)
import Data.Functor (($>))



type Parsed a = forall f. (Alternative f, Monad f) => f (a, Text)
newtype ReadP a = P (
    Text -> (forall f. (Alternative f, Monad f) => f (a, Text)))
class Parse a where
    parser :: ReadP a
    parse :: forall f. (Monad f, Alternative f) => String -> f a


instance Functor ReadP where
    fmap f (P x) = P (
        \t -> fmap (first f) (x t))
instance Applicative ReadP where
    pure x = P (
        \t -> pure (x, t))
    (P f) <*> (P x) = P (
        \t -> f t >>=
        \(f, t) -> x t >>= 
        \(x, t) -> pure (f x, t))
instance Alternative ReadP where
    empty = P (
        \t -> empty)
    (<|>) :: ReadP a -> ReadP a -> ReadP a
    (P a) <|> (P b) = P (
        \t -> a t <|> b t)
(P a) <++ (P b) = P (
    \t -> case a t of
        Nothing -> b t
        Just x  -> pure x)
get = P (
    \t -> case uncons t of
        Nothing      -> empty
        Just (x, xs) -> pure (x, xs))
char c = P (
    \t -> case uncons t of
        Nothing      -> empty
        Just (x, xs) -> if x == c
            then pure (x, xs)
            else empty)
satisfy p = P (
    \t -> case uncons t of
        Nothing      -> empty
        Just (x, xs) -> if p x
            then pure (x, xs)
            else empty)
string s = let s' = fromString s in P (
    \t -> if s' `isPrefixOf` t
        then pure (s, T.drop (length s) t)
        else empty)
munch p = P (\t -> pure (g t)) where
    g t = case uncons t of
        Nothing      -> ([], t)
        Just (x, xs) -> if p x
            then first (x:) (g xs)
            else ([], t)
manyTill (P p) (P end) = P (\t -> g t) where
    g t = fmap (first (const [])) (end t) <|>
        (p t >>=
        \(x, t) -> fmap (first (x:)) (g t))