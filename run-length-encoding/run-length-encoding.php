<?php

declare(strict_types=1);

function encode(string $input): string
{
    $output = '';
    $count = 1;
    $chars = str_split($input);
    while (key($chars) !== null) {
        $char = current($chars);
        if ($char !== next($chars)) {
            $output .= ($count > 1) ? $count . $char : $char;
            $count = 0;
        }
        $count++;
    }
    return $output;
}

function decode(string $input): string
{
    $output = '';
    $count = 0;
    foreach (str_split($input) as $char) {
        if (ctype_digit($char)) {
            $count = $count * 10 + (int)$char;
            continue;
        }
        $output .= str_repeat($char, ($count) ? $count : 1);
        $count = 0;
    }
    return $output;
}
