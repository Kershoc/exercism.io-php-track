<?php
declare(strict_types=1);

function getClassification(int $number): string
{
    $classification = new NicomachusClassification($number);
    return $classification->getClassification();
}

class NicomachusClassification
{
    const NUMBER_PERFECT = 'perfect';
    const NUMBER_ABUNDANT = 'abundant';
    const NUMBER_DEFICIENT = 'deficient';
    /** @var int $number */
    private $number;
    
    public function __construct(int $number)
    {
        if ($number < 1) {
            throw new InvalidArgumentException();
        }
        $this->number = $number;
    }

    public function getClassification(): string
    {
        switch(($sum = $this->aliquotSum()) <=> $this->number) {
            case 1:
                return self::NUMBER_ABUNDANT;
            case 0:
                if ($sum !== 1) return self::NUMBER_PERFECT;
            default:
            case -1:
                return self::NUMBER_DEFICIENT;
        }
    }

    private function aliquotSum(): int
    {
        $sum = 1;
        for($i=2; $i**2 < $this->number; $i++) {
            if($this->number%$i === 0){
                $sum += $i + $this->number/$i;
            }
        }
        return $sum;
    }
}
