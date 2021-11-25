<?php

declare(strict_types=1);

function maskify(string $cc): string
{
    $regex = "/\d(?<!^\d)(?=(?:\D*\d){4})/";
    return preg_replace($regex, "#", $cc);
}
