<?php
declare(strict_types=1);

function parse_binary(string $binary): int
{
    if (preg_match('/[^01]/', $binary)) {
        throw new InvalidArgumentException("Invalid Binary.  Ones and Zeros only pls.");
    }

    $res = 0;
    foreach (str_split(strrev($binary)) as $k => $v) {
        $res += $v * 2**$k;
    }
    return $res;
}
