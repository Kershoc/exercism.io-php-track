<?php

declare(strict_types=1);

function toRna(string $dna): string
{
    $map = [
        'G' => 'C',
        'C' => 'G',
        'T' => 'A',
        'A' => 'U'
    ];
    return strtr($dna, $map);
}
