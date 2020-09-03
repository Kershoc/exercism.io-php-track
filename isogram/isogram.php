<?php
declare(strict_types=1);

function isIsogram(string $subject): bool
{
    $subject = mb_strtolower(str_replace(['-',' '],'', $subject));
    $letters = mb_str_split($subject);
    return $letters === array_unique($letters);
}
