<?php
declare(strict_types=1);

class Bob
{
    private $heard;

    public function respondTo(string $heard): string
    {
        $this->heard = preg_replace('/\s+/u', '', $heard);

        if ($this->heard === '') {
            return "Fine. Be that way!";
        }

        if ($this->isShouting() && $this->isQuestion()) {
            return "Calm down, I know what I'm doing!";
        }

        if ($this->isShouting()) {
            return "Whoa, chill out!";
        }

        if ($this->isQuestion()) {
            return "Sure.";
        }

        return "Whatever.";
    }

    private function isShouting(): bool
    {
        return $this->heard === mb_strtoupper($this->heard) && preg_match('/\p{L}/u',$this->heard);
    }

    private function isQuestion(): bool
    {
        return mb_substr($this->heard, -1) === '?';
    }
}
