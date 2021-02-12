<?php

function diamond(string $endLetter): array
{
    if (!in_array($endLetter, range('A', 'Z'))) {
        throw new InvalidArgumentException('Single letter A-Z please');
    }
    $output = [];
    $letters = range('A', $endLetter);
    $midPoint = count($letters);
    $i = 1;
    $cpCount = -1;
    foreach ($letters as $letter) {
        $pad = str_repeat(' ', $midPoint - $i);
        $cPad = str_repeat(' ', ($cpCount < 0) ? 0 : $cpCount);
        $output[] = ($i > 1) ? $pad . $letter . $cPad . $letter . $pad : $pad . $letter . $pad;
        $i++;
        $cpCount += 2;
    }
    $tail = array_reverse($output);
    array_shift($tail);
    return array_merge($output, $tail);
}
