module Main (main) where
import qualified JSON as J


main = 
    readFile ".\\config.json" >>=
    \jsonText -> print (read jsonText :: J.JSON) *>
    putStrLn "Good bye"