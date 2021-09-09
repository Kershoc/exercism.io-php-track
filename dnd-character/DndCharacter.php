<?php

declare(strict_types=1);

class DndCharacter
{
    private const BASE_HP = 10;
    private const ABILITY_DIE = 4;
    private const ABILITY_DIE_KEEP = 3;
    private const ABILITY_DIE_SIDES = 6;

    public $strength;
    public $dexterity;
    public $constitution;
    public $intelligence;
    public $wisdom;
    public $charisma;
    public $hitpoints;

    public function __construct()
    {
    }

    public static function modifier(int $stat): int
    {
        return (int) floor(($stat - 10) / 2);
    }

    public static function ability(): int
    {
        $rolls = Dice::roll(self::ABILITY_DIE_SIDES, self::ABILITY_DIE);
        rsort($rolls);
        return array_sum(array_slice($rolls, 0, self::ABILITY_DIE_KEEP));
    }

    public static function generate()
    {
        $character = new self();
        $stats = get_class_vars(self::class);
        foreach ($stats as $stat => $value) {
            $character->$stat = self::ability();
        }
        $character->hitpoints = $character->calcHP();
        return $character;
    }

    private function calcHP(): int
    {
        return self::BASE_HP + self::modifier($this->constitution);
    }
}

class Dice
{
    public static function roll(int $sides, int $nDie): array
    {
        $rolls = [];
        for ($i = 0; $i < $nDie; $i++) {
            $rolls[] = self::rollD($sides);
        }
        return $rolls;
    }

    private static function rollD(int $sides): int
    {
        return rand(1, $sides);
    }
}
