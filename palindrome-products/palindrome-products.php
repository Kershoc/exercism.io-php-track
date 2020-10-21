<?php
function largest(int $min, int $max)
{
    if ($min > $max) {
        throw new Exception();
    }
    $products = paliProducts(range($min, $max));
    $num = array_pop($products);
    if (!$num) {
        throw new Exception();
    }
    $factors = factor($num, $min, $max);
    return [$num, $factors];
}

function smallest(int $min, int $max)
{
    if ($min > $max) {
        throw new Exception();
    }
    $products = paliProducts(range($min, $max));
    $num = array_shift($products);
    if (!$num) {
        throw new Exception();
    }
    $factors = factor($num, $min, $max);
    return [$num, $factors];
}

function paliProducts(array $range)
{
    $return = [];
    foreach ($range as $num) {
        foreach($range as $num1) {
            $product = $num * $num1;
            if ((string)$product === strrev($product)) {
                $return = array_merge($return, [$product]);
            }
        }
    }
    sort($return);
    return $return;
}

function factor(int $num, int $min, int $max)
{
    $return = [];
    for ($i = $min; $i <= sqrt($num); $i++) {
        if ($num % $i === 0) {
            $num1 = $num / $i;
            if ($num1 > $max) {
                continue;
            }
            array_push($return, [$i, $num1]);
        }
    }
    return $return;
}
