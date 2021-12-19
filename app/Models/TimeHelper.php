<?php

namespace App\Models;

use Carbon\Carbon;

class TimeHelper
{
    public static function georgian2jalali($timestamp)
    {
        $carbon = Carbon::parse($timestamp);
        $array = \Morilog\Jalali\CalendarUtils::toJalali($carbon->year, $carbon->month, $carbon->day);
        $year = (string) $array[0];
        $month = (string)$array[1];
        $day = (string)$array[2];
        return (new \Morilog\Jalali\Jalalian($year, $month, $day))->format('%A, %d %B %Y');
    }
}
