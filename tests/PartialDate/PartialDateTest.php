<?php

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
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('01:05 21.07.2017');
        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     *  01: 21.07.2017 (неизвестны минуты)
     */
    public function testConstructNoMinutesDate()
    {
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('01: 21.07.2017');
        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     * 21.07.2017 (только дата)
     */
    public function testConstructNoTimeDate()
    {
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('21.07.2017');
        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     * 07.2017 (известен месяц и год)
     */
    public function testConstructOnlyMonthAndYearDate()
    {
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('07.2017');
        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     * 2017 (известен год)
     */
    public function testConstructOnlyYearDate()
    {
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('2017');
        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     * 01: (известен час)
     */
    public function testConstructOnlyHourDate()
    {
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('01:');
        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     * 01:05 (известен час и минуты)
     */
    public function testConstructHourMinuteDate()
    {
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('01:05');
        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     * 01:05:17 (известно полностью время)
     */
    public function testConstructTimeDate()
    {
        $partialDate = new \Oprokidnev\PartialDate\PartialDate('01:05:17');
        $this->assertInstanceOf(\Oprokidnev\PartialDate\PartialDate::class, $partialDate);
    }

    /**
     *
     * Trying to compare with a string value
     *
     * @depends testConstructOnlyYearDate
     */
    public function testCompareWithString()
    {
        $this->expectException(\Oprokidnev\PartialDate\Exception\InvalidComparisonArgumentException::class);
        $partialDate2017 = new \Oprokidnev\PartialDate\PartialDate('2017');
        $partialDate2017->compareTo('Wow some string');
    }

    /**
     *
     * Trying to compare with a string value
     *
     * @depends testConstructTimeDate
     * @depends testConstructOnlyHourDate
     */
    public function testCompareWithOnlyTimeObjects()
    {
        $this->expectException(\Oprokidnev\PartialDate\Exception\UncomparableException::class);
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01:05:17');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('01:');
        $partialDateA->compareTo($partialDateB);
    }

    /**
     *
     * Compare 2017 and 2018 year dates
     *
     * @depends testConstructOnlyYearDate
     */
    public function testCompareTwoYears()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('2018');
        $this->assertEquals($partialDateA->compareTo($partialDateB), -1, 'Date 2017 should return -1 in comparison with 2018');
    }

    /**
     *
     * Compare 2018 and 2017 dates
     *
     * @depends testConstructOnlyYearDate
     */
    public function testCompareTwoYearsBackward()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('2018');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('2017');
        $this->assertEquals($partialDateA->compareTo($partialDateB), 1, 'Date 2018 should return 1 in comparison with 2017');
    }

    /**
     *
     * Compare 01.2017 and 02.2017 dates
     *
     * @depends testConstructOnlyMonthAndYearDate
     */
    public function testCompareTwoMonths()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('02.2017');
        $this->assertEquals($partialDateA->compareTo($partialDateB), -1, 'Date 01.2017 should return 1 in comparison with 02.2017');
    }

    /**
     *
     * Compare 02.01.2017 and 04.02.2018 dates
     *
     * @depends testConstructNoTimeDate
     */
    public function testCompareTwoDays()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('02.01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('04.02.2018');
        $this->assertEquals($partialDateA->compareTo($partialDateB), -1, 'Date 02.01.2017 should return -1 in comparison with 04.02.2018');
    }

    /**
     *
     * Compare 02.01.2017 and 02.2018 dates
     *
     * @depends testConstructNoTimeDate
     * @depends testConstructOnlyMonthAndYearDate
     */
    public function testCompareDayWithMonth()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('02.01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('02.2018');
        $this->assertEquals($partialDateA->compareTo($partialDateB), -1, 'Date 02.01.2017 should return -1 in comparison with 04.02.2018');
    }

    /**
     *
     * Compare 02.01.2017 and 02.2018 dates
     *
     * @depends testConstructOnlyYearDate
     * @depends testConstructOnlyMonthAndYearDate
     */
    public function testCompareMonthWithYear()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('2018');
        $this->assertEquals($partialDateA->compareTo($partialDateB), -1, 'Date 02.01.2017 should return -1 in comparison with 04.02.2018');
    }

    /**
     *
     * Compare 01.2017 and 2017 dates
     *
     * @depends testConstructOnlyYearDate
     * @depends testConstructOnlyMonthAndYearDate
     */
    public function testIntersectionUnobviousException()
    {
        $this->expectException(\Oprokidnev\PartialDate\Exception\UnobviousResultException::class);
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('2017');
        $partialDateA->compareTo($partialDateB);
    }

    /**
     *
     * Compare 01.01.2017 and 01.2018 year dates
     *
     * @depends testConstructOnlyYearDate
     * @depends testConstructOnlyMonthAndYearDate
     */
    public function testMonthIntersectionUnobviousException()
    {
        $this->expectException(\Oprokidnev\PartialDate\Exception\UnobviousResultException::class);
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01.01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('01.2017');
        $partialDateA->compareTo($partialDateB);
    }

    /**
     *
     * Compare 01:01 01.01.2017 and 01:02 01.01.2017 dates
     *
     * @depends testConstructNoSecondsDate
     */
    public function testTimeAwareDates()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01:01 01.01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('01:02 01.01.2017');
        $partialDateA->compareTo($partialDateB);
        $expected     = -1;

        $this->assertEquals($expected, $partialDateA->compareTo($partialDateB),
            \sprintf('Date %s should return %s in comparison with %s', $partialDateA->getDateString(), $expected, $partialDateB->getDateString()));
    }

    /**
     *
     * Compare 01:01:01 01.01.2017 and 01:01:02 01.01.2017 dates
     *
     * @depends testConstructFullDate
     */
    public function testTimeAwareDates2()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01:01:02 01.01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('01:01:01 01.01.2017');
        $partialDateA->compareTo($partialDateB);
        $expected     = 1;

        $this->assertEquals($expected, $partialDateA->compareTo($partialDateB),
            \sprintf('Date %s should return %s in comparison with %s', $partialDateA->getDateString(), $expected, $partialDateB->getDateString()));
    }

    /**
     *
     * Compare 01:01:01 01.01.2017 and 01.01.2017 dates
     *
     * @depends testConstructFullDate
     * @depends testConstructNoTimeDate
     */
    public function testTimeAwareDates3()
    {
        $this->expectException(\Oprokidnev\PartialDate\Exception\UnobviousResultException::class);
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01:01:02 01.01.2017');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('01.01.2017');
        $partialDateA->compareTo($partialDateB);
    }

    /**
     *
     * Compare 01:01:02 01.02.1990 and 01:01:01 01.02.1990 dates
     *
     * @depends testConstructFullDate
     * @depends testConstructNoTimeDate
     */
    public function testDateСomplementTimeDates()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01:01:02');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('01:01:01');
        $expected     = 1;


        $this->assertEquals($expected, $partialDateA->withDate(new \Oprokidnev\PartialDate\PartialDate('01.02.1990'))->compareTo($partialDateB->withDate(new \Oprokidnev\PartialDate\PartialDate('01.02.1990'))), \sprintf('Date %s should return %s in comparison with %s', $partialDateA->getDateString(), $expected, $partialDateB->getDateString()));
    }

    /**
     *
     * Compare 01:01:02 01.02.1990 and 01:01:01 01.02.1990 dates
     *
     * @depends testConstructFullDate
     * @depends testConstructNoTimeDate
     */
    public function testDateСomplementTimeDates1()
    {
        $partialDateA = new \Oprokidnev\PartialDate\PartialDate('01:01:02');
        $partialDateB = new \Oprokidnev\PartialDate\PartialDate('01:01:01');
        $expected     = -1;

        $this->assertEquals($expected, $partialDateA->withDate(new \Oprokidnev\PartialDate\PartialDate('01.02.1990'))->compareTo(
                $partialDateB->withDate(new \Oprokidnev\PartialDate\PartialDate('01.02.1991'))
            ), \sprintf('Date %s should return %s in comparison with %s', $partialDateA->getDateString(), $expected, $partialDateB->getDateString()));
    }
}
