<?php
function from(DateTimeImmutable $dateTime)
{
    return $dateTime->add(new DateInterval('PT1000000000S'));
}