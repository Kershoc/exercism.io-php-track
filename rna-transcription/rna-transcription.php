<?php

function toRna(string $input): string
{
    $map = [
        'G' => 'C',
        'C' => 'G',
        'T' => 'A',
        'A' => 'U'
    ];
    $return = '';
    foreach (str_split($input) as $char) {
        $return .= $map[$char];
    }
    return $return;
}
