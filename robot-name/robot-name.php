<?php
declare(strict_types=1);

class Robot
{
    private $inventory;
    private $name;

    public function __construct()
    {
        $this->inventory = RobotInventory::getInstance();
        $this->reset();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function reset(): void
    {
        do {
            $name = $this->genName();
        } while ($this->inventory->contains($name));
        $this->inventory->register($name);
        $this->name = $name;
    }

    private function genName(): string
    {
        $prefix = implode('', array_rand(array_flip(range('A', 'Z')), 2));
        $suffix = str_pad((string)rand(0, 999), 3, "0", STR_PAD_LEFT);
        return $prefix . $suffix;
    }
}

class RobotInventory
{
    private $inventory = [];
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new RobotInventory();
        }
        return self::$instance;
    }

    public function register(string $name): void
    {
        array_push($this->inventory, $name);
    }

    public function contains(string $name): bool
    {
        return in_array($name, $this->inventory);
    }
}
