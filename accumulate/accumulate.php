<?php

function accumulate(array $input, callable $accumulator)
{
    $return = [];
    foreach ($input as $item) {
        array_push($return, call_user_func($accumulator, $item));
    }
    return $return;
}
