<?php
 function sumOfSquares(int $nthNumber): int
 {
    // Σn2 = [n(n+1)(2n+1)]/6
    return ($nthNumber * ($nthNumber + 1) * (2 * $nthNumber + 1)) / 6;
 }

function squareOfSum(int $nthNumber): int
{
    // [n(n+1)/2]^2
    return ($nthNumber * ($nthNumber + 1) / 2) ** 2;
}

function difference(int $nthNumber): int
{
    return squareOfSum($nthNumber) - sumOfSquares($nthNumber);
}
