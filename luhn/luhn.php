<?php

function isValid(string $ccnum): bool
{
    $luhn = new Luhn($ccnum);
    return $luhn->clean()->validate();
}

class Luhn
{
    private $ccnum;

    public function __construct(string $ccnum)
    {
        $this->ccnum = $ccnum;
    }

    public function clean(): self
    {
        $this->ccnum = preg_replace('/\s+/u', '', $this->ccnum);
        return $this;
    }

    public function validate(): bool
    {
        if ( strlen($this->ccnum) < 2 || preg_match('/\D/u', $this->ccnum) ) {
            return false;
        }

        return $this->calculate() === 0;
    }

    private function calculate(): int
    {
        $digits = str_split(strrev($this->ccnum));
        $result = '';
        foreach ($digits as $i => $d) {
            $result .= $i % 2 !==0 ? $d*2 : $d;
        }

        return (array_sum(str_split($result)) % 10);
    }
}
