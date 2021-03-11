<?php

declare(strict_types=1);

function sumOfMultiples(int $num, array $multiples): int
{
    $multiples = array_filter($multiples);

    $result = [];
    foreach (range(1, $num - 1) as $check) {
        foreach ($multiples as $m) {
            if ($check % $m == 0) {
                $result[] = $check;
                break;
            }
        }
    }

    return array_sum($result);
}
