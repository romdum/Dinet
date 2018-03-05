<?php

namespace Dinet;

use \DateTime;

class UtilDate
{
    const DATE_FORMAT_EN = 'Y-m-d';
    const DATE_FORMAT_FR = 'd-m-Y';
    const TIME_FORMAT_EN = self::DATE_FORMAT_EN . ' H:i:s';
    const TIME_FORMAT_FR = self::DATE_FORMAT_FR . ' H:i:s';

    const ONE_DAY  = 60 * 60 * 24;
    const ONE_WEEK = self::ONE_DAY * 7;

    public static function firstDayOfWeek( DateTime $date = null )
    {
        $newDate = $date === null ? new DateTime() : clone $date;

        $newDate->modify( 'monday this week' );

        return $newDate->getTimestamp();
    }

    public static function lastDayOfWeek( DateTime $date = null )
    {
        $newDate = $date === null ? new DateTime() : clone $date;

        $newDate->modify( $newDate->format( 'w' ) === '0' ? 'now' : 'sunday this week');

        return $newDate->getTimestamp();
    }
}