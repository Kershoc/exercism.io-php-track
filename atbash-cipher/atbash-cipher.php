<?php
declare(strict_types=1);

function encode(string $input): string
{
    $alphabet = range('a','z');
    $cypher = array_combine($alphabet, array_reverse($alphabet));

    $input = mb_strtolower($input);

    $out = '';
    foreach (mb_str_split($input) as $char) {
        if (array_key_exists($char,$cypher)) {
            $out .= $cypher[$char];
        }
        if (ctype_digit($char)) {
            $out .= $char;
        }
    }
    return trim(chunk_split($out, 5, ' '));
}
