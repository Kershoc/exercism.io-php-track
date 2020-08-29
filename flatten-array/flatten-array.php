<?php

declare(strict_types=1);

function flatten(array $input):array
{
    return array_reduce($input, function ($res, $item) {
        if (is_array($item)) {
            $res = array_merge($res, flatten($item));
        } elseif (!is_null($item)) {
            $res[] = $item;
        }
        return $res;
    }, []);
}
