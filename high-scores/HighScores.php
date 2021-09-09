<?php

declare(strict_types=1);

class HighScores
{
    public $scores;
    public $latest;
    public $personalBest;
    public $personalTopThree;

    public function __construct(array $scores)
    {
        $this->scores = $scores;
        $this->latest = $this->scores[count($this->scores) - 1];
        $this->personalBest = max($this->scores);
        $this->personalTopThree = $this->personalTopThree();
    }

    private function personalTopThree()
    {
        $scores = $this->scores;
        rsort($scores);
        return array_slice($scores, 0, 3);
    }
}
