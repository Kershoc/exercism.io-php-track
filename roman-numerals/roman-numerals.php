<?php
declare(strict_types=1);

function toRoman(int $number): string
{
    $romanNumeral = new RomanNumerals($number);
    return $romanNumeral->carve();
}

class RomanNumerals
{
    /**
    * @var string[] $ones
    */
    private $ones = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX'];
    /**
    * @var string[] $tens
    */
    private $tens = ['', 'X', 'XX', 'XXX', 'XL', 'L', 'LX', 'LXX', 'LXXX', 'XC'];
    /**
    * @var string[] $huns
    */
    private $huns = ['', 'C', 'CC', 'CCC', 'CD', 'D', 'DC', 'DCC', 'DCCC', 'CM'];
    /**
    * @var string[] $thou
    */
    private $thou = [''];
    /**
    * @var int $number
    */
    private $number;

    public function __construct(int $number)
    {
        $this->number = $number;
        $this->fillThousands();
        if ($this->number > 9999) {
            throw new InvalidArgumentException("Sorry, I cannot count that high.");
        }
    }

    public function carve(): string
    {
        list($thou, $huns, $tens, $ones) = array_map('intval', str_split(str_pad(strval($this->number), 4, "0", STR_PAD_LEFT)));
        return $this->thou[$thou] . $this->huns[$huns] . $this->tens[$tens] . $this->ones[$ones];
    }

    private function fillThousands(): void
    {
        $m = '';
        for ($i=1; $i<10; $i++) {
            $m .= 'M';
            array_push($this->thou, $m);
        }
    }
}
