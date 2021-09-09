<?php

declare(strict_types=1);

define('LOWERBOUND', ord('a'));
define('UPPERBOUND', ord('z'));
define('ALPHABET_LENGTH', 26);
define('ENCODE', 1);
define('DECODE', -1);

class SimpleCipher
{
    public $key;

    public function __construct(string $key = null)
    {
        if ($key !== null && preg_match('/[^a-z]|^$/', $key)) {
            throw new InvalidArgumentException('Invalid Key');
        }

        $this->key = $key ?? $this->randomkey();
    }

    public function encode(string $plainText): string
    {
        return $this->translate($plainText, ENCODE);
    }

    public function decode(string $cipherText): string
    {
        return $this->translate($cipherText, DECODE);
    }

    private function distance(int $keyidx): int
    {
        return ord($this->key[$keyidx % strlen($this->key)]) - LOWERBOUND;
    }

    private function wrap(int $charCode): int
    {
        if ($charCode > UPPERBOUND) {
            return $charCode - ALPHABET_LENGTH;
        }
        if ($charCode < LOWERBOUND) {
            return $charCode + ALPHABET_LENGTH;
        }
        return $charCode;
    }

    private function translate(string $input, int $direction): string
    {
        $out = '';
        foreach (str_split($input) as $idx => $chr) {
            $out .= $this->translateChar($chr, $this->distance($idx) * $direction);
        }
        return $out;
    }

    private function translateChar(string $char, int $distance): string
    {
        return chr($this->wrap(ord($char) + $distance));
    }

    public function randomChar(): string
    {
        return chr(rand(LOWERBOUND, UPPERBOUND));
    }

    public function randomkey(): string
    {
        $out = '';
        while (strlen($out) <= 100) {
            $out .= $this->randomChar();
        }
        return $out;
    }
}
