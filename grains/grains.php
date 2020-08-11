<?php

function square(int $num): string
{
    if ($num < 1) {
        throw new InvalidArgumentException("Positive numbers only please");
    }

    if ($num > 64) {
        throw new InvalidArgumentException("Lower then 64 please");
    }

    return bcdiv(bcpow('2', (string)$num), '2');
}

function total(): string
{
    $total = '';
    foreach (range(1,64) as $square) {
        $total = bcadd($total, square($square));
    }
    return $total;
}
