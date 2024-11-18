<?php

namespace App\Helpers;

use DateTime;
use DateInterval;

class DateHelper
{
    public static function substractDate($dateTimeString, $fromFormat, int $days)
    {
        $date = DateTime::createFromFormat($fromFormat, $dateTimeString);
        $newDate = new DateInterval('P' . $days . 'D');
        $date->sub($newDate);
        return $date;
    }

    public static function formateDate($dateTimeString, $fromFormat = 'm/d/Y', $toFormat = 'Y-m-d')
    {
        $date = DateTime::createFromFormat($fromFormat, $dateTimeString);
        return $date->format($toFormat);
    }
}
