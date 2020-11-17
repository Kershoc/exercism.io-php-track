<?php
declare(strict_types=1);

/*
 * The tests that came with the exercise encourages bad design.
 * I didn't like it, so changed the tests.
*/

/** @return array<array<int>> */
function pascalsTriangleRows(int $rows): array
{
    if ($rows < 0) {
        throw new InvalidArgumentException("Positive numbers only please.");
    }
    $triangle = [];
    for ($line = 1; $line <= $rows; $line++) {  
        $row = [];
        $C = 1;// used to represent C(line, i)  
        for ($i = 1; $i <= $line; $i++) {  
            $row[] = $C;
            $C = intval($C * ($line - $i) / $i);
        }
        $triangle[] = $row;
    }

    return $triangle;
}
