<?php

declare(strict_types=1);

class Series
{
    private $series;
    public function __construct(string|int $series)
    {
        $series = (string) $series;
        if (preg_match('/\D/', $series)) {
            throw new InvalidArgumentException('Series can contain only numbers.');
        }
        $this->series = str_split($series);
    }

    public function largestProduct(int $span): int
    {
        if ($span > count($this->series)) {
            throw new InvalidArgumentException("Span cannot be larger then series.");
        }
        if ($this->series[0] === '' && $span !== 0) {
            throw new InvalidArgumentException("Span cannot be greater then 0 with an empty series.");
        }
        if ($span < 0) {
            throw new InvalidArgumentException("Span must be positive.");
        }
        if ($span === 0) {
            return 1;
        }

        $stop = (count($this->series) - $span) + 1;
        $position = 0;
        $largest = 0;
        while ($position != $stop) {
            $product = array_reduce(
                array_slice($this->series, $position, $span),
                fn($accumulator, $value) => $accumulator * $value,
                1
            );
            if ($product > $largest) {
                $largest = $product;
            }
            $position++;
        }
        return $largest;
    }
}
