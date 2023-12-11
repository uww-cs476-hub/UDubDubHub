{-# OPTIONS_GHC -Wno-unrecognised-pragmas #-}
{-# HLINT ignore "Avoid lambda" #-}
{-# LANGUAGE LambdaCase #-}
import Data.Int (Int64)
import Control.Monad.ST.Strict (ST, runST)
import Data.Array.ST (STArray, MArray (newArray, getBounds), readArray)
import Control.Applicative (Alternative (empty))

class Eq a => Hash a where
    hash :: a -> Int64
data HashBucket k v =
    Pair k v |
    TombStone k v |
    Empty
newtype HashMap k v a = HashMap (
    forall s. STArray s Int64 (HashBucket k v) -> ST s a)
instance forall k v. Functor (HashMap k v) where
    fmap f (HashMap x) = HashMap (
        \st -> fmap f (x st))
instance forall k v. Applicative (HashMap k v) where
    pure x = HashMap (
        \st -> pure x)
    (HashMap f) <*> (HashMap x) = HashMap (
        \st -> f st >>=
        \f -> x st >>=
        \x -> pure (f x))
instance forall k v. Monad (HashMap k v) where
    (HashMap x) >>= kleisli = HashMap (
        \st -> x st >>=
        \x -> let (HashMap y) = kleisli x in y st)

get :: (Alternative f, Hash k) => k -> HashMap k v (f v)
get k = HashMap (
    \table -> getBounds table >>=
    \(lo, hi) -> let
        start = (hash k `mod` (hi - lo + 1)) + lo
        wa i = if i > hi then lo else i
        search i = if i == start
            then pure empty
            else readArray table i >>= \case
                Pair k' v -> if k == k'
                    then pure (pure v)
                    else search (wa (i + 1))
                TombStone k' v -> if k == k'
                    then pure empty
                    else search (wa (i + 1))
                Empty -> pure empty
    in readArray table start >>=
    \case
        Pair k' v      -> if k == k'
            then pure (pure v)
            else search (wa (start + 1))
        TombStone k' v -> if k == k'
            then pure empty
            else search (wa (start + 1))
        Empty          -> search (wa (start + 1)))
put :: Hash k => k -> v -> HashMap k v ()
put = undefined 
runHashMap :: Hash k => HashMap k v a -> a
runHashMap (HashMap f) = runST (newArray (0,0) Empty >>= f)