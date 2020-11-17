<?php
declare(strict_types=1);

function translate(string $input): string
{
    $translator = new IgpayAtinlayAnslatortay($input);
    return $translator->translate();
}

class IgpayAtinlayAnslatortay
{
    private const SPLIT_REGEX = "/\b(s?qu|(?!yt|xr)[^aeiou ]+|)(\w+)/i";
    /** @var string $input */
    private $input = '';

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function translate(): string
    {
        $output = preg_replace(self::SPLIT_REGEX, "$2$1ay", $this->input);
        if (is_null($output)) throw new Exception("Error translating input.");
        return $output;
    }
}
