<?php

declare(strict_types=1);

function calculate(string $input): int
{
    $parser = new Parser(new Lexer($input));
    return $parser->parse();
}

class Token
{
    public const REGEX = "/(?:(?<OP>^What is|plus|minus|multiplied by|divided by|raised to the)[\s?]?)|(?:(?<NUM>-?\d+)(?:st|nd|rd|th)?(?: power)?[\s?]?)|(?<UNKNOWN>.+)/";
    public const OP = 'OP';
    public const NUM = 'NUM';
    public const UNKNOWN = 'UNKNOWN';

    public function __construct(private string $type, private string $value)
    {
    }

    public function getValue(): string|int
    {
        return ($this->isNum()) ? intval($this->value) : $this->toCamelCase();
    }
    public function is(string $type): bool
    {
        return $this->type === $type;
    }

    public function isOp(): bool
    {
        return $this->is(self::OP);
    }

    public function isNum(): bool
    {
        return $this->is(self::NUM);
    }

    public function isUnknown(): bool
    {
        return $this->is(self::UNKNOWN);
    }

    private function toCamelCase(): string
    {
        return lcfirst(str_replace(' ', '', ucwords($this->value)));
    }
}

class Lexer
{
    public function __construct(private string $input)
    {
    }

    public function getTokens(): Generator
    {
        $offset = 0;
        while (preg_match(Token::REGEX, $this->input, $match, 0, $offset)) {
            yield $this->tokenize($match);
            $offset += strlen($match[0]);
        }
    }

    private function tokenize(array $regexMatch): Token
    {
        foreach ($regexMatch as $type => $value) {
            if (strlen($value) > 0 && defined("Token::$type")) {
                return new Token(constant("Token::$type"), $value);
            }
        }
    }
}

class Parser
{
    public function __construct(private Lexer $lexer)
    {
    }

    public function parse(): int
    {
        $this->tokens = $this->lexer->getTokens();
        $result = 0;
        while ($pair = $this->getPair()) {
            $result = $pair->calculate($result);
        }
        return $result;
    }

    private function getPair(): OpNumPair|false
    {
        $op = $this->getToken();
        $num = $this->getToken();
        if ($op === null) {
            return false;
        }
        return new OpNumPair($op, $num);
    }

    private function getToken()
    {
        $current = $this->tokens->current();
        $this->tokens->next();
        return $current;
    }
}

class OpNumPair
{
    public function __construct(private Token $op, private Token|null $num)
    {
        $this->validate();
    }
    public function calculate(int $input): int
    {
        $op = $this->op->getValue();
        return Ops::$op($input, $this->num->getValue());
    }
    private function validate()
    {
        if ($this->op->isUnknown()) {
            throw new InvalidArgumentException("Unknown Operation");
        }
        if (!$this->isBalanced() || !$this->op->isOp() || !$this->num->isNum()) {
            throw new InvalidArgumentException("Syntax Error");
        }
    }
    private function isBalanced(): bool
    {
        return $this->op instanceof Token && $this->num instanceof Token;
    }
}

class Ops
{
    public static function whatIs(int $_, int $b): int
    {
        return $b;
    }

    public static function plus(int $a, int $b): int
    {
        return $a + $b;
    }

    public static function minus(int $a, int $b): int
    {
        return $a - $b;
    }

    public static function multipliedBy(int $a, int $b): int
    {
        return $a * $b;
    }

    public static function dividedBy(int $a, int $b): int
    {
        return $a / $b;
    }

    public static function raisedToThe(int $a, int $b): int
    {
        return $a ** $b;
    }
}
