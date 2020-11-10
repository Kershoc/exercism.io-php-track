<?php
declare(strict_types=1);

function isValid(string $ccnum): bool
{
    $luhn = new Luhn($ccnum);
    return $luhn->clean()->validate();
}

class Luhn
{
    /** @var string $ccnum */
    private $ccnum;

    public function __construct(string $ccnum)
    {
        $this->ccnum = $ccnum;
    }

    public function clean(): self
    {
        $scrubbed_ccnum = preg_replace('/\s+/u', '', $this->ccnum);
        if (is_null($scrubbed_ccnum)) {
            throw new Exception("Error cleaning CC Number");
        }
        $this->ccnum = $scrubbed_ccnum;
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
            $result .= $i % 2 !==0 ? intval($d)*2 : $d;
        }

        return (array_sum(str_split($result)) % 10);
    }
}
