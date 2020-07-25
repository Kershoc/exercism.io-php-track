<?php
declare(strict_types=1);

function isArmstrongNumber(int $subject): bool
{
    $power = (int)ceil(log10($subject));
    $clone = $subject;
    $res = 0;
    while($clone > 0) {
        $res += ($clone%10)**$power;
        $clone /= 10;
    }
    return $res === $subject;
}
