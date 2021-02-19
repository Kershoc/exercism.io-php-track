<?php

declare(strict_types=1);

// Solved Using Technique Learned From Here
// https://www.geeksforgeeks.org/generate-a-combination-of-minimum-coins-that-results-to-a-given-value

function findFewestCoins(array $denominations, int $amount): array
{
    if ($amount < 0) {
        throw new InvalidArgumentException("Cannot make change for negative value");
    }
    if ($amount < min($denominations) && $amount > 0) {
        throw new InvalidArgumentException("No coins small enough to make change");
    }

    $table = array_fill(1, $amount, PHP_INT_MAX);
    $table[0] = 0;
    $table[$amount + 1] = [];

    for ($i = 1; $i <= $amount; $i++) {
        foreach ($denominations as $coin) {
            if ($coin <= $i) {
                $res = $table[$i - $coin];
                if ($res !== PHP_INT_MAX && $res + 1 < $table[$i]) {
                    $table[$i] = $res + 1;
                }
            }
        }
    }

    if ($table[$amount] === PHP_INT_MAX) {
        throw new InvalidArgumentException('No combination can add up to target');
    }
    findSolution($amount, $denominations, $table);
    return $table[$amount + 1];
}

function findSolution(int $amount, array $denominations, array &$table): void
{
    foreach ($denominations as $coin) {
        if ($amount - $coin >= 0 && $table[$amount - $coin] + 1 == $table[$amount]) {
            $table[count($table) - 1][] = $coin;
            findSolution($amount - $coin, $denominations, $table);
            break;
        }
    }
}
