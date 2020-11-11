<?php
declare(strict_types=1);

/** @param array<string> $input */
function recognize(array $input): string
{
    $ocr = new OCRNumber($input);
    return $ocr->parse()->toDigits();
}

class OCRNumber
{
    private const NUMBERS = [
        ' _ | ||_|   ' => '0',
        '     |  |   ' => '1',
        ' _  _||_    ' => '2',
        ' _  _| _|   ' => '3',
        '   |_|  |   ' => '4',
        ' _ |_  _|   ' => '5',
        ' _ |_ |_|   ' => '6',
        ' _   |  |   ' => '7',
        ' _ |_||_|   ' => '8',
        ' _ |_| _|   ' => '9'
    ];

    private const ROW_LENGTH = 4;
    private const COL_LENGTH = 3;
    private const ROW_SEPARATOR = ',';
    private const UNKNOWN_DIGIT = '?';

    /** @var array<string> $input */
    private $input;
    /** @var array<array<string>> $digits */
    private $digits = [];

    /** @param array<string> $input */
    public function __construct(array $input)
    {
        $this->input = $input;
        $this->validate();
    }

    public function parse(): self
    {
        $rpos = 0;
        foreach ($this->input as $k => $row) {
            $this->parseRow($row, $rpos);
            ($k+1)%self::ROW_LENGTH !== 0 ?: $rpos++;
        }
        return $this;
    }

    public function toDigits(): string
    {
        $out = "";
        $lastRow = $this->digits[count($this->digits)-1];
        foreach ($this->digits as $row) {
            foreach ($row as $digit) {
                $out .= self::NUMBERS[$digit] ?? self::UNKNOWN_DIGIT;
            }
            $row === $lastRow ?: $out .= self::ROW_SEPARATOR;
        }
        return $out;
    }

    private function parseRow(string $row, int $rpos): void
    {
        $this->digits[$rpos] ?? $this->digits[$rpos] = [];
        $parts = str_split($row, self::COL_LENGTH);
        $cpos = 0;
        foreach($parts as $char) {
            $this->digits[$rpos][$cpos] ?? $this->digits[$rpos][$cpos] = '';
            $this->digits[$rpos][$cpos] .= $char;
            $cpos++;
        }
    }

    private function validate(): void
    {
        if (count($this->input)%self::ROW_LENGTH!==0) {
            throw new InvalidArgumentException("Row length must be a multiple of ".self::ROW_LENGTH);
        }
        foreach ($this->input as $row) {
            if (strlen($row)%self::COL_LENGTH!==0) {
                throw new InvalidArgumentException("Column length must be a multiple of ".self::COL_LENGTH);
            }
        }
    }
}
