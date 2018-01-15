<?php

function firstDayOfWeek( DateTime $date = null )
{
    $newDate = $date === null ? new DateTime() : clone $date;

    $newDate->modify( $newDate->format( 'w' ) === '0' ? 'monday last week' : 'monday this week');

    return date( 'd' , $newDate->getTimestamp() );
}

function lastDayOfWeek( DateTime $date = null )
{
    $newDate = $date === null ? new DateTime() : clone $date;

    $newDate->modify( $newDate->format( 'w' ) === '0' ? 'now' : 'sunday this week');

    return date( 'd', $newDate->getTimestamp() );
}
