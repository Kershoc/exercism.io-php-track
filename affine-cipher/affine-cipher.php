<?php
declare(strict_types=1);

define('ALPHABET', range('a','z'));
define('CYPHER', array_flip(ALPHABET));
define('ALPHABET_LENGTH', count(ALPHABET));

// E(x) = (ax + b) mod m
function encode(string $text, int $akey, int $bkey): string
{
    if (!isCoPrime($akey, ALPHABET_LENGTH)) {
        throw new Exception("Error: a and m must be coprime.");
    }
    $text = mb_strtolower($text);

    $out = '';
    foreach(mb_str_split($text) as $char) {
        if (array_key_exists($char,CYPHER)) {
            $key = ($akey*CYPHER[$char] + $bkey) % ALPHABET_LENGTH;
            $out .= ALPHABET[$key];
        }
        if (ctype_digit($char)) {
            $out .= $char;
        }
    }
    return trim(chunk_split($out, 5, ' '));
}

// D(y) = a^-1(y - b) mod m
function decode(string $text, int $akey, int $bkey): string
{
    if (!isCoPrime($akey, ALPHABET_LENGTH)) {
        throw new Exception("Error: a and m must be coprime.");
    }
    $mmi = gmp_intval(gmp_invert($akey, ALPHABET_LENGTH));
    $text = mb_strtolower($text);

    $out = '';
    foreach(mb_str_split($text) as $char) {
        if (array_key_exists($char,CYPHER)) {
            $key = $mmi * (CYPHER[$char] - $bkey) % ALPHABET_LENGTH;
            while($key < 0) {
                $key += ALPHABET_LENGTH;
            }
            $out .= ALPHABET[$key];
        }
        if (ctype_digit($char)) {
            $out .= $char;
        }
    }
    return $out;
}

function isCoPrime(int $a, int $b): bool
{
    return gmp_intval(gmp_gcd($a, $b)) === 1;
}
