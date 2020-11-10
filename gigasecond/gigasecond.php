<?php
function from(DateTimeImmutable $dateTime): DateTimeImmutable
{
    return $dateTime->add(new DateInterval('PT1000000000S'));
}
