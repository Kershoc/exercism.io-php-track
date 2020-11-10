<?php
declare(strict_types=1);

function brackets_match(string $input): bool
{
    $brackets = new MatchingBrackets($input);
    return $brackets->isValid();
}

class MatchingBrackets
{
    private const BRACKETS = [
        '['=>']',
        '{'=>'}',
        '('=>')'
    ];
    /** @var array<string> $nest */
    private $nest = [];
    /** @var string $input */
    private $input = '';

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function isValid(): bool
    {
        foreach(mb_str_split($this->input) as $char) {
            switch(true):
                case(in_array($char, array_keys(self::BRACKETS))):
                    array_push($this->nest, $char);
                    break;
                case(in_array($char, self::BRACKETS)):
                    $check = array_pop($this->nest);
                    if ($check && self::BRACKETS[$check] !== $char) {
                        return false;
                    }
                    break;
            endswitch;
        }

        return empty($this->nest);
    }
}
