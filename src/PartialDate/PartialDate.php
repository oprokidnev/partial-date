<?php
declare(strict_types=1);

/*
 * Copyright 2017 Oprokidnev Andrey
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Oprokidnev\PartialDate;

/**
 * PartialDate
 *
 * @author oprokidnev
 */
class PartialDate implements Comparable
{
    /**
     *
     * @var string
     */
    private $dateString = null;

    /**
     *
     * @var int
     */
    private $seconds = null;

    /**
     *
     * @var int
     */
    private $minutes = null;

    /**
     *
     * @var int
     */
    private $hours = null;

    /**
     *
     * @var int
     */
    private $day = null;

    /**
     *
     * @var int
     */
    private $month = null;

    /**
     *
     * @var int
     */
    private $year = null;

    public function __construct(string $dateString)
    {
        $this->dateString = $dateString;

        switch (true) {
            /*
             * Benchmarking showed that this regexp is MORE EXPENSIVE than multiple small regexp evaluation.
             */
            case false && \preg_match('/^(?J)(?<hours>\d{2}):(?<minutes>\d{2}):(?<seconds>\d{2}) (?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})$|'.
                '^(?<hours>\d{2}):(?<minutes>\d{2}) (?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})$|'.
                '^(?<hours>\d{2}): (?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})$|'.
                '^(?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})$|'.
                '^(?<month>\d{2}).(?<year>\d{4})$|'.
                '^(?<year>\d{4})$|'.
                '^(?<hours>\d{2}):$|'.
                '^(?<hours>\d{2}):(?<minutes>\d{2})$|'.
                '^(?<hours>\d{2}):(?<minutes>\d{2}):(?<seconds>\d{2})$'.
                '/s', $dateString, $matches):

                $this->hours   = $matches['hours'] !== '' ? (int) $matches['hours'] : null;
                $this->minutes = $matches['minutes'] !== '' ? (int) $matches['minutes'] : null;
                $this->seconds = $matches['seconds'] !== '' ? (int) $matches['seconds'] : null;
                $this->day     = $matches['day'] !== '' ? (int) $matches['day'] : null;
                $this->month   = $matches['month'] !== '' ? (int) $matches['month'] : null;
                $this->year    = $matches['year'] !== '' ? (int) $matches['year'] : null;
                break;

            /**
             * 01:00:05 21.07.2017 (известная полная дата со временем)
             */
            case \preg_match('/^(?<hours>\d{2}):(?<minutes>\d{2}):(?<seconds>\d{2}) (?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})$/s', $dateString, $matches):
                $this->hours   = (int) $matches['hours'];
                $this->minutes = (int) $matches['minutes'];
                $this->seconds = (int) $matches['seconds'];
                $this->day     = (int) $matches['day'];
                $this->month   = (int) $matches['month'];
                $this->year    = (int) $matches['year'];
                break;
            /**
             * 01:05 21.07.2017 (секунды неизвестны)
             */
            case \preg_match('/^(?<hours>\d{2}):(?<minutes>\d{2}) (?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})$/s', $dateString, $matches):
                $this->hours   = (int) $matches['hours'];
                $this->minutes = (int) $matches['minutes'];
                $this->seconds = null;
                $this->day     = (int) $matches['day'];
                $this->month   = (int) $matches['month'];
                $this->year    = (int) $matches['year'];

                break;
            /**
             * 01: 21.07.2017 (неизвестны минуты)
             */
            case \preg_match('/^(?<hours>\d{2}): (?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})$/s', $dateString, $matches):
                $this->hours   = (int) $matches['hours'];
                $this->minutes = null;
                $this->seconds = null;
                $this->day     = (int) $matches['day'];
                $this->month   = (int) $matches['month'];
                $this->year    = (int) $matches['year'];
                break;
            /**
             *  21.07.2017 (только дата)
             */
            case \preg_match('/^(?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})$/s', $dateString, $matches):
                $this->hours   = null;
                $this->minutes = null;
                $this->seconds = null;
                $this->day     = (int) $matches['day'];
                $this->month   = (int) $matches['month'];
                $this->year    = (int) $matches['year'];
                break;
            /**
             * 07.2017 (известен месяц и год)
             */
            case \preg_match('/^(?<month>\d{2}).(?<year>\d{4})$/s', $dateString, $matches):
                $this->hours   = null;
                $this->minutes = null;
                $this->seconds = null;
                $this->day     = null;
                $this->month   = (int) $matches['month'];
                $this->year    = (int) $matches['year'];
                break;
            /**
             * 2017 (известен год)
             */
            case \preg_match('/^(?<year>\d{4})$/s', $dateString, $matches):
                $this->hours   = null;
                $this->minutes = null;
                $this->seconds = null;
                $this->day     = null;
                $this->month   = null;
                $this->year    = (int) $matches['year'];
                break;
            /**
             * 01: (известен час)
             */
            case \preg_match('/^(?<hours>\d{2}):$/s', $dateString, $matches):
                $this->hours   = (int) $matches['hours'];
                $this->minutes = null;
                $this->seconds = null;
                $this->day     = null;
                $this->month   = null;
                $this->year    = null;
                break;
            /**
             * 01:05 (известен час и минуты)
             */
            case \preg_match('/^(?<hours>\d{2}):(?<minutes>\d{2})$/s', $dateString, $matches):
                $this->hours   = (int) $matches['hours'];
                $this->minutes = (int) $matches['minutes'];
                $this->seconds = null;
                $this->day     = null;
                $this->month   = null;
                $this->year    = null;
                break;
            /**
             * 01:05:17 (известно полностью время)
             */
            case \preg_match('/^(?<hours>\d{2}):(?<minutes>\d{2}):(?<seconds>\d{2})$/s', $dateString, $matches):
                $this->hours   = (int) $matches['hours'];
                $this->minutes = (int) $matches['minutes'];
                $this->seconds = (int) $matches['seconds'];
                $this->day     = null;
                $this->month   = null;
                $this->year    = null;
                break;
            default:
                throw new Exception\InvalidDateFormatException($dateString);
                break;
        }
    }

    /**
     *
     * Implements an unconfirmed rfc that will allow to compare objects using operators.
     * May be changed if
     *
     * @param \Oprokidnev\PartialDate\PartialDate $other
     *
     * @throws Exception\UncomparableException
     * @throws Exception\InvalidComparisonArgumentException
     */
    public function compareTo($other)
    {
        if ($other instanceof PartialDate) {
            if (!($this->hasDate() || $other->hasDate())) {
                throw new Exception\UncomparableException($this, $other);
            }
            return $this->doCompare($other);
        }
        throw new Exception\InvalidComparisonArgumentException($other);
    }

    public function toDateTimeRange()
    {
        /*
         * Calculating minimum date
         */
        $minDateTime = new \DateTime();
        $minDateTime->setDate($this->year, $this->month ?? 1, $this->day ?? 1);
        $minDateTime->setTime($this->hours ?? 0, $this->minutes ?? 0, $this->seconds ?? 0, 0);

        /*
         * Calculating maximum date
         */
        $maxDateTime = new \DateTime();
        if ($this->month === null) {
            $maxDateTime->setDate($this->year + 1, 1, 0);
        } elseif ($this->month !== null && $this->day === null) {
            $maxDateTime->setDate($this->year, $this->month + 1, 0);
        } elseif ($this->month !== null && $this->day !== null) {
            $maxDateTime->setDate($this->year, $this->month, $this->day);
        }

        $maxDateTime->setTime($this->hours ?? 23, $this->minutes ?? 59, $this->seconds ?? 59, 999999);

        return new DateTimeRange($minDateTime, $maxDateTime);
    }

    public function hasDate()
    {
        return $this->year !== null;
    }

    public function getSeconds()
    {
        return $this->seconds;
    }

    public function getMinutes()
    {
        return $this->minutes;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getDateString()
    {
        return $this->dateString;
    }

    public function withDate(PartialDate $partialDate)
    {
        foreach (['year', 'month', 'day'] as $propertyName) {
            $getter              = 'get'.\ucfirst($propertyName);
            ${$propertyName}     = $this->$propertyName;
            $this->$propertyName = $partialDate->{$getter}();
        }

        $instance = clone $this;

        foreach (['year', 'month', 'day'] as $propertyName) {
            $this->$propertyName = ${$propertyName};
        }

        return $instance;
    }

    protected function doCompare(PartialDate $compareTo)
    {
        $a = $this->toDateTimeRange();
        $b = $compareTo->toDateTimeRange();
        if ($b->getMaxDateTime() < $a->getMinDateTime()) {
            return 1;
        }
        if ($b->getMinDateTime() > $a->getMaxDateTime()) {
            return -1;
        }
        if ($b->getMinDateTime() === $a->getMinDateTime() && $b->getMaxDateTime() === $a->getMaxDateTime()) {
            return 0;
        }
        throw new Exception\UnobviousResultException($this, $compareTo);
    }
}
