<?php

declare(strict_types=1);

class Matrix 
{
    private $matrix = [];

    public function __construct(string $matrix)
    {
        foreach (explode('\n', $matrix) as $row) {
            $this->matrix[] = explode(' ', $row);
        }
    }

    public function getRow(int $idx): array
    {
        return $this->matrix[$idx-1];
    }

    public function getColumn(int $idx): array
    {
        return array_column($this->matrix, $idx-1);
    }
}
