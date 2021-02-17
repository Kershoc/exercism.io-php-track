<?php

declare(strict_types=1);

function transpose($input): array
{
    $transposed = [];
    $length = array_reduce($input, function ($len, $row) {
        return (strlen($row) > $len) ? strlen($row) : $len;
    }, 0);
    foreach ($input as $row) {
        $row = str_pad($row, $length);
        foreach (str_split($row) as $key => $value) {
            $transposed[$key][] = $value;
        }
    }
    $transposed = array_map('implode', $transposed);
    $transposed[count($transposed) - 1] = rtrim($transposed[count($transposed) - 1]);
    return $transposed;
}
