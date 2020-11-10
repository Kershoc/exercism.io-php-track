<?php
declare(strict_types=1);

define('MONTHS', [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
]);

function meetup_day(int $year, int $month, string $descriptor, string $day): DateTimeImmutable
{
    $date_string = $descriptor . ' ' . $day . ' of ' . MONTHS[$month] . ' ' . $year;

    if ($descriptor === 'teenth') {
        $date_string = implode('/', [$month, get_teenth($day, $month, $year), $year]);
    }
    
    return new DateTimeImmutable($date_string);
}

function get_teenth(string $day, int $month, int $year): int
{
    foreach (range(13,19) as $dom) {
        $date = implode('/', [$month, $dom, $year]);
        if ($timestamp = strtotime($date)) {
            $dow = date('l', $timestamp);
            if ($day === $dow) return $dom;
        }
    }
    throw new RangeException("Day Not Found in Range");
}
