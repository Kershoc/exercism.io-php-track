<?php
function sieve(int $upperBound): array
{
    if ($upperBound < 2) {
        return [];
    }
    $range = range(2, $upperBound);
    foreach ($range as $number) {
        $range = array_filter($range, function ($value) use ($number) {
            if ($value <= $number) {
                return true;
            }
            if ($value % $number === 0) {
                return false;
            }
            return true;
        });
    }
    return array_values($range);
}
