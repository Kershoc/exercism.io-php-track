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
    private const LEFT = "L";
    private const RIGHT = "R";
    private const ADVANCE = "A";

    public $position = [0,0];
    public $direction = self::DIRECTION_NORTH;

    public function __construct(array $position, int $direction)
    {
        if (count($position) !== 2) {
            throw new InvalidArgumentException('[x,y] coords only please.');
        }
        if ($position !== array_filter($position, 'is_int')) {
            throw new InvalidArgumentException('[x,y] coords must be integers');
        }
        if ($direction < self::DIRECTION_NORTH || $direction > self::DIRECTION_WEST) {
            throw new InvalidArgumentException('Invalid Direction');
        }
        $this->position = $position;
        $this->direction = $direction;
    }

    public function turnLeft(): self
    {
        $this->direction--;
        if ($this->direction < self::DIRECTION_NORTH) {
             $this->direction = self::DIRECTION_WEST;
        }
        return $this;
    }

    public function turnRight(): self
    {
        $this->direction++;
        if ($this->direction > self::DIRECTION_WEST) {
            $this->direction = self::DIRECTION_NORTH;
        }
        return $this;
    }

    public function advance(): self
    {
        switch ($this->direction) {
            case self::DIRECTION_NORTH:
                $this->position[self::Y_AXIS]++;
                break;
            case self::DIRECTION_EAST:
                $this->position[self::X_AXIS]++;
                break;
            case self::DIRECTION_SOUTH:
                $this->position[self::Y_AXIS]--;
                break;
            case self::DIRECTION_WEST:
                $this->position[self::X_AXIS]--;
                break;
        }
        return $this;
    }

    public function instructions(string $instructions): void
    {
        foreach (str_split($instructions) as $instruction) {
            switch ($instruction) {
                case self::LEFT:
                    $this->turnLeft();
                    break;
                case self::RIGHT:
                    $this->turnRight();
                    break;
                case self::ADVANCE:
                    $this->advance();
                    break;
                default:
                    throw new InvalidArgumentException('I do not understand - ' . $instruction);
            }
        }
    }
}
