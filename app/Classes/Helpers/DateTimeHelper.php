<?php


namespace App\Classes\Helpers;


use App\Interfaces\HelperInterface;
use DateTime;

class DateTimeHelper implements HelperInterface
{
    const FORMAT_YMD = "Y.m.d";
    const FORMAT_FULL = self::FORMAT_YMD." h:i";
    const FORMAT_FULL_WITH_SEC = self::FORMAT_FULL.":s";

    /**
     * @param int $timestamp
     * @return DateTime
     */
    public function getDateTimeFromTimestamp(int $timestamp): DateTime
    {
        $date = new DateTime();
        $date->setTimestamp($timestamp);

        return $date;
    }
}
