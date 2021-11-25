<?php

declare(strict_types=1);

function toOrdinal(int $number): string
{
    if (!$number) {
        return "0";
    }
    if (!in_array($number%100, [11,12,13])) {
        switch ($number%10):
            case 1:
                return $number . "st";
            case 2:
                return $number . "nd";
            case 3:
                return $number . "rd";
        endswitch;
    }
    return $number . 'th';
}
