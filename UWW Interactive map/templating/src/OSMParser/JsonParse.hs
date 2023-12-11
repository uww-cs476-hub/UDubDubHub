module JsonParse where
import Text.Read (Read(readPrec), lift)
import Text.ParserCombinators.ReadP (satisfy, char, string, choice, readS_to_P)
import Text.ParserCombinators.ReadPrec ((<++))
import Data.Functor (($>))
import GHC.IO (unsafePerformIO)
import Control.Applicative (Alternative(empty))

--formal grammer of JSON: https://www.json.org/json-en.html
--This module implements the formal grammer of JSON using Parser Combinators
--The object the module reads is an AST for JSON, to get a JSON value,
--use the Read instance of JSON.hs

data WS = WS Char WS | WSEmpty
instance Read WS where readPrec = (WS <$> lift (satisfy (`elem` "\x0020\x000A\x000D\x0009")) <*> readPrec) <++ pure WSEmpty 
data Sign = NoSign | Positive | Negative
instance Read Sign where readPrec = (lift (char '+') $> Positive) <++ (lift (char '-') $> Negative) <++ pure NoSign 
newtype OneNine = OneNine Char
instance Read OneNine where readPrec = OneNine <$> lift (satisfy (`elem` "123456789"))

data Digit = Zero | Digit OneNine
instance Read Digit where readPrec = (lift (char '0') $> Zero) <++ (Digit <$> readPrec)
data Digits = OneDigit Digit | Digits Digit Digits
instance Read Digits where readPrec = (Digits <$> readPrec <*> readPrec) <++ (OneDigit <$> readPrec)
data Hex = Hex Char | HexDigit Digit
instance Read Hex where readPrec = (Hex <$> lift (satisfy (`elem` "abcdefABCDEF"))) <++ (HexDigit <$> readPrec)

data Exponent = ExponentEmpty | Exponent Char Sign Digits
instance Read Exponent where readPrec = (Exponent <$> lift (satisfy (`elem` "eE")) <*> readPrec <*> readPrec) <++ pure ExponentEmpty
data Fraction = FractionEmpty | Fraction Digits
instance Read Fraction where readPrec = (lift (char '.') *> (Fraction <$> readPrec)) <++ pure FractionEmpty
data JInteger = JIntegerSingle Digit | JInteger OneNine Digits | JIntegerSingleSigned Digit | JIntegerSigned OneNine Digits
instance Read JInteger where 
    readPrec = (lift (char '-') *> (JIntegerSigned <$> readPrec <*> readPrec)) <++
        (lift (char '-') *> (JIntegerSingleSigned <$> readPrec)) <++
        (JInteger <$> readPrec <*> readPrec) <++ (JIntegerSingle <$> readPrec)
data Escape = Escape Char | EscapeHex Hex Hex Hex Hex
instance Read Escape where 
    readPrec = (Escape <$> lift (satisfy (`elem` "\"\\/bfnrt"))) <++ 
        (EscapeHex <$> readPrec <*> readPrec <*> readPrec <*> readPrec)
data JNumber = JNumber JInteger Fraction Exponent
instance Read JNumber where readPrec = JNumber <$> readPrec <*> readPrec <*> readPrec
data Character = Character Char | CharacterEscape Escape
instance Read Character where 
    readPrec = (Character <$> lift (satisfy (\x -> x >= '\x0020' && x <= '\x10FFFF' && x /= '"' && x /= '\\'))) <++
        (lift (char '\\') *> (CharacterEscape <$> readPrec))
data Characters = CharactersEmpty | Characters Character Characters
instance Read Characters where readPrec = (Characters <$> readPrec <*> readPrec) <++ pure CharactersEmpty
newtype JString = JString Characters
instance Read JString where readPrec = lift (char '"') *> (JString <$> readPrec) <* lift (char '"')

data Element = Element WS Value WS
instance Read Element where readPrec = Element <$> readPrec <*> readPrec <*> readPrec
data Elements = ElementSingle Element | Elements Element Elements
instance Read Elements where
    readPrec = (Elements <$> readPrec <* lift (char ',')<*> readPrec) <++ (ElementSingle <$> readPrec)
data Array = ArrayEmpty WS | Array Elements
instance Read Array where 
    readPrec = (lift (char '[') *> (ArrayEmpty <$> readPrec) <* lift (char ']')) <++
        (lift (char '[') *> (Array <$> readPrec) <* lift (char ']'))
data Member = Member WS JString WS Element
instance Read Member where readPrec = Member <$> readPrec <*> readPrec <*> readPrec <* lift (char ':') <*> readPrec
data Members = MemberSingle Member | Members Member Members
instance Read Members where readPrec = (Members <$> readPrec <* lift (char ',') <*> readPrec) <++ (MemberSingle <$> readPrec) 
data Object = ObjectEmpty WS | Object Members
instance Read Object where 
    readPrec = (lift (char '{') *> (ObjectEmpty <$> readPrec) <* lift (char '}')) <++
        (lift (char '{') *> (Object <$> readPrec) <* lift (char '}'))
data Value = ValueObject Object | ValueArray Array | ValueString JString | ValueNumber JNumber | ValueLiteral String
instance Read Value where 
    readPrec = (ValueObject <$> readPrec) <++ (ValueArray <$> readPrec) <++ (ValueString <$> readPrec) <++ 
        (ValueNumber <$> readPrec) <++ (ValueLiteral <$> lift (choice [
            string "true", string "false", string "null"]))
newtype JSON = JSON Element
instance Read JSON where readPrec = JSON <$> readPrec