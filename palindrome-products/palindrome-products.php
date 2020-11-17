<?php
/** @return array{int, array<array<int>>} */
function largest(int $min, int $max): array
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

/** @return array{int, array<array<int>>} */
function smallest(int $min, int $max): array
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

/** 
 * @param array<int> $range
 * @return array<int> 
 * */
function paliProducts(array $range): array
{
    $return = [];
    foreach ($range as $num) {
        foreach($range as $num1) {
            $product = $num * $num1;
            if (strval($product) === strrev(strval($product))) {
                $return = array_merge($return, [$product]);
            }
        }
    }
    sort($return);
    return $return;
}

/** @return array<array<int>> */
function factor(int $num, int $min, int $max): array
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
