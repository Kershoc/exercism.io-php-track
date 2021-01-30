<?php

declare(strict_types=1);

class Robot
{
    public const DIRECTION_NORTH = 1;
    public const DIRECTION_EAST = 2;
    public const DIRECTION_SOUTH = 3;
    public const DIRECTION_WEST = 4;
    private const X_AXIS = 0;
    private const Y_AXIS = 1;
    private const L = 'turnLeft';
    private const R = 'turnRight';
    private const A = 'advance';
    private $compass = [
        self::DIRECTION_NORTH,
        self::DIRECTION_EAST,
        self::DIRECTION_SOUTH,
        self::DIRECTION_WEST
    ];

    public $position = [0,0];

    public function __get(string $name)
    {
        if ($name === 'direction') {
            return $this->{$name}();
        }
    }

    public function __construct(array $position, int $direction)
    {
        if (count($position) !== 2) {
            throw new InvalidArgumentException('[x,y] coords only please.');
        }
        if ($position !== array_filter($position, 'is_int')) {
            throw new InvalidArgumentException('[x,y] coords must be integers');
        }
        if (!in_array($direction, $this->compass)) {
            throw new InvalidArgumentException('Invalid Direction');
        }
        $this->position = $position;
        while (current($this->compass) !== $direction) {
            next($this->compass);
        }
    }

    public function turnLeft(): self
    {
        return $this->turn('prev');
    }

    public function turnRight(): self
    {
        return $this->turn('next');
    }

    public function advance(): self
    {
        $axis = (current($this->compass) % 2 === 0) ? self::X_AXIS : self::Y_AXIS;
        (current($this->compass) > self::DIRECTION_EAST) ? $this->position[$axis]-- : $this->position[$axis]++;
        return $this;
    }

    public function instructions(string $instructions): void
    {
        foreach (str_split($instructions) as $instruction) {
            if (!defined("self::$instruction")) {
                throw new InvalidArgumentException('I do not understand - ' . $instruction);
            }
            $this->{constant("self::$instruction")}();
        }
    }

    private function turn(string $direction): self
    {
        $direction($this->compass);
        if (key($this->compass) === null) {
            ($direction == 'next') ? reset($this->compass) : end($this->compass);
        }
        return $this;
    }

    private function direction()
    {
        return current($this->compass);
    }
}
