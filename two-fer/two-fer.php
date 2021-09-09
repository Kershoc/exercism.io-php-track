<?php

function twoFer(string $name = null): string
{
    $quote = "One for you, one for me.";
    if ($name) {
        $quote = str_replace('you', $name, $quote);
    }
    return $quote;
}
