<?php

use Spatie\CalendarLinks\Link;

$from = DateTime::createFromFormat('Y-m-d H:i', '2018-02-01 09:00');
$to = DateTime::createFromFormat('Y-m-d H:i', '2018-02-01 18:00');

$link = Link::create('Sebastian’s birthday', $from, $to)
    ->description('Cookies & cocktails!')
    ->address('Kruikstraat 22, 2018 Antwerpen');





// Generate a link to create an event on Google calendar
echo $link->google();

// Generate a link to create an event on Yahoo calendar
echo $link->yahoo();

// Generate a link to create an event on outlook.live.com calendar
echo $link->webOutlook();

// Generate a link to create an event on outlook.office.com calendar
echo $link->webOffice();

// Generate a data uri for an ics file (for iCal & Outlook)
echo $link->ics();

// Generate a data URI using arbitrary generator:

echo $link->formatWith(new \Your\Generator());



Link::create(
    'Birthday',
    DateTime::createFromFormat('Y-m-d H:i', '2018-02-01 09:00'),
    DateTime::createFromFormat('Y-m-d H:i', '2018-02-01 18:00')
)->google();