<?php

namespace Opilo\Farsi;


class JalaliFormatter
{

    protected static $conversionFunctions = [
        'd' => 'get2DigitDay',
        'j' => 'getDay',
        'z' => 'getDayOfYear',
        'm' => 'get2DigitMonth',
        'M' => 'getMonthName',
        'n' => 'getMonth',
        't' => 'getNumberOfDaysInMonth',
        'L' => 'isLeapYear',
        'Y' => 'getYear',
        'y' => 'get2DigitYear',
        'w' => 'getWeakDay',
        'D' => 'getWeakDayName',
    ];

    protected static $monthNames = [
        'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
    ];

    protected static $weekDays = [
        'شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'
    ];

    /**
     * @param JalaliDate $date
     * @param string $format
     * @param bool $farsiDigits whether to convert english digits to farsi
     * @return string
     */
    public static function JalaliToString(JalaliDate $date, $format, $farsiDigits = true)
    {
        $output = '';
        $funcitons = str_split($format);
        foreach ($funcitons as $function) {
            if(array_key_exists($function, static::$conversionFunctions)){
                $f = static::$conversionFunctions[$function];
                $output .= static::$f($date);
            } else {
                $output .= $function;
            }
        }

        if($farsiDigits) {
            $output = DigitConverter::toFarsi($output);
        }

        return $output;
    }

    protected static function get2DigitDay(JalaliDate $date)
    {
        $day = static::getDay($date);
        return strlen($day) == 1 ? '0' . $day : $day;
    }

    protected static function getDay(JalaliDate $date)
    {
        return (string) $date->getDay();
    }

    protected static function getDayOfYear(JalaliDate $date)
    {
        return (string) $date->dayOfYear();
    }

    protected static function get2DigitMonth(JalaliDate $date)
    {
        $month = static::getMonth($date);
        return strlen($month) == 1 ? '0' . $month : $month;
    }

    protected static function getMonthName(JalaliDate $date)
    {
        return static::$monthNames[$date->getMonth() - 1];
    }

    protected static function getMonth(JalaliDate $date)
    {
        return (string) $date->getMonth();
    }

    protected static function getNumberOfDaysInMonth(JalaliDate $date)
    {
        return (string) JalaliDate::getDaysInMonth($date->getMonth());
    }

    protected static function isLeapYear(JalaliDate $date)
    {
        return JalaliDate::isLeapYear($date->getYear()) ? '1' : '0';
    }

    protected static function getYear(JalaliDate $date)
    {
        return (string) $date->getYear();
    }

    protected static function get2DigitYear(JalaliDate $date)
    {
        $year = $date->getYear() % 100;
        return strlen($year) == 1 ? '0' . $year : $year;
    }

    protected static function getWeakDay(JalaliDate $date)
    {
        return (string) $date->getWeakDay();
    }

    protected static function getWeakDayName(JalaliDate $date)
    {
        return static::$weekDays[$date->getWeakDay()];
    }
}