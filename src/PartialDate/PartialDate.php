<?php
declare(strict_types=1);
/*
 * Copyright 2017 Oprokidnev Andrey
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Oprokidnev\PartialDate;

/**
 * Description of PartialDate
 *
 * @author oprokidnev
 */
class PartialDate
{

    /**
     *
     * @var integer
     */
    private $seconds = null;
    private $minutes = null;
    private $hours   = null;
    private $day     = null;
    private $month   = null;
    private $year    = null;

    /**
     *
     * @todo
     */
    private $timezone;

    public function __construct(string $dateString)
    {
        switch (true) {
            case \preg_match('/(?<hours>\d{2}):(?<minutes>\d{2}):(?<seconds>\d{2}) (?<day>\d{2}).(?<month>\d{2}).(?<year>\d{4})/siU', $dateString, $matches):
                list(
                    'hours' => $this->hours,
                    'minutes' => $this->minutes,
                    'seconds' => $this->seconds,
                    'day' => $this->day,
                    'month' => $this->month,
                    'year' => $this->year,
                ) = [
                    'hours'   => (int) $matches['hours'],
                    'minutes' => (int) $matches['minutes'],
                    'seconds' => (int) $matches['seconds'],
                    'day'     => (int) $matches['day'],
                    'month'   => (int) $matches['month'],
                    'year'    => (int) $matches['year'],
                ];
                break;
            default:
                throw new Exception\InvalidDateFormatException($dateString);
                break;
        }
    }
}