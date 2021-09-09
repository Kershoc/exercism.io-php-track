<?php

declare(strict_types=1);

class Triangle
{
    private $sides;

    public function __construct(float ...$sides)
    {
        $this->sides = $sides;
        sort($this->sides);
    }
    private function validate()
    {
        if (count($this->sides) !== 3) {
            throw new Exception("invalid sides: triangle have 3");
        }
        array_walk($this->sides, function ($side) {
            if ($side <= 0) {
                throw new Exception("invalid side: positive numbers only");
            }
        });

        if ($this->sides[0] + $this->sides[1] < $this->sides[2]) {
            throw new Exception("invalid: not a triangle");
        }
    }

    public function kind()
    {
        $this->validate();

        if ($this->sides[0] == $this->sides[2]) {
            return 'equilateral';
        }

        if ($this->sides[0] == $this->sides[1] || $this->sides[1] == $this->sides[2]) {
            return 'isosceles';
        }

        return 'scalene';
    }
}
