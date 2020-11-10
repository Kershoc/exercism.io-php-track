<?php
class Clock
{
    const DAY_IN_MINUTES = 1440;
    /** @var int $minutes */
    private $minutes;

    public function __construct(int $hour, int $minutes = 0)
    {
        $this->minutes = ($hour*60) + $minutes;
        while ($this->minutes < 0) {
            $this->minutes += self::DAY_IN_MINUTES;
        }
        $this->minutes %= self::DAY_IN_MINUTES;
    }

    public function add(int $minutes):Clock
    {
        return new self(0, $this->minutes + $minutes);
    }

    public function sub(int $minutes):Clock
    {
        return new self(0, $this->minutes - $minutes);
    }

    public function __toString():string
    {
        return sprintf("%02d:%02d",$this->minutes/60,$this->minutes%60);
    }
}
