<?php
declare(strict_types=1);

function prime(int $nthPrime): int
{
    if ($nthPrime < 1) {
        throw new InvalidArgumentException("Positive numbers only");
    }
    $next = 1;
    while ($nthPrime > 0) {
        $next++;
        if (isPrime($next)) $nthPrime--;
    }
    return $next;
}

function isPrime(int $n): bool
{
    if ($n < 2) return false;
    if ($n < 4) return true;
    if ($n%2===0 || $n%3===0) return false;

    for ($i = 5; $i**2 <= $n; $i+=6) {
        if ($n % $i === 0 || $n % ($i + 2) === 0) return false;
    }

    return true;
}
