<?php
/*
 * Copyright 2017 Oprokidnev Andrey
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Oprokidnev\Tests\PartialDate;

/**
 * Description of PartialDateTest
 *
 * @author oprokidnev
 */
class PartialDateTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * Incompatible format date
     */
    public function testConstructException()
    {
        $this->expectException(\Oprokidnev\PartialDate\Exception\InvalidDateFormatException::class);
        // Stop here and mark this test as incomplete.
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('Some strange format here...');
    }

    /**
     *
     * 01:00:05 21.07.2017 (известная полная дата со временем)
     */
    public function testConstructFullDate()
    {
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('01:00:05 21.07.2017');

        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     *  01:05 21.07.2017 (секунды неизвестны)
     */
    public function testConstructNoSecondsDate()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     *
     *  01: 21.07.2017 (неизвестны минуты)
     */
    public function testConstructNoMinutesDate()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     *
     * 21.07.2017 (только дата)
     */
    public function testConstructNoTimeDate()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     *
     * 07.2017 (известен месяц и год)
     */
    public function testConstructOnlyMonthAndYearDate()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     *
     * 2017 (известен год)
     */
    public function testConstructOnlyYearDate()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     *
     * 01: (известен час)
     */
    public function testConstructOnlyHourDate()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     *
     * 01:05 (известен час и минуты)
     */
    public function testConstructHourMinuteDate()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     *
     * 01:05:17 (известно полностью время)
     */
    public function testConstructTimeDate()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}