<?php

declare(strict_types=1);

class School
{
    private $roster = [];
    public function add(string $student, int $grade): void
    {
        $this->roster[$grade][] = $student;
    }

    public function grade(int $grade): array
    {
        return $this->roster[$grade] ?? [];
    }

    public function studentsByGradeAlphabetical(): array
    {
        $roster = $this->roster;
        foreach ($roster as &$students) {
            sort($students);
        }
        asort($roster);
        return $roster;
    }
}
