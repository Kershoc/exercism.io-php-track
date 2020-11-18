<?php
declare(strict_types=1);

/** @return array<int> */
function factors(int $num): array 
{
    $divisor = 2;
    $return = [];
    while ($num > 1) {
        if ($num % $divisor === 0) {
            array_push($return, $divisor);
            $num /= $divisor;
        } else {
            $divisor++;
        }
    }
    return $return;
}
