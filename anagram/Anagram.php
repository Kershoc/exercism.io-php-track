<?php

declare(strict_types=1);

function detectAnagrams(string $word, array $words): array
{
    return array_values(array_filter($words, fn($v) => isAnagram($word, $v)));
}

function isAnagram($test, $subject): bool
{
    $test = mb_strtolower($test);
    $subject = mb_strtolower($subject);
    return $test !== $subject && count_chars($test) === count_chars($subject);
}
