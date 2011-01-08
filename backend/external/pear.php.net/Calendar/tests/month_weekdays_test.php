<?php
// $Id: month_weekdays_test.php 300728 2010-06-24 11:43:56Z quipo $

require_once 'simple_include.php';
require_once 'calendar_include.php';

require_once './calendar_test.php';

class TestOfMonthWeekdays extends TestOfCalendar {
    function TestOfMonthWeekdays() {
        $this->UnitTestCase('Test of Month Weekdays');
    }
    function setUp() {
        $this->cal = new Calendar_Month_Weekdays(2003, 10);
    }
    function testPrevDay () {
        $this->assertEqual(30,$this->cal->prevDay());
    }
    function testPrevDay_Array () {
        $this->assertEqual(
            array(
                'year'   => 2003,
                'month'  => 9,
                'day'    => 30,
                'hour'   => 0,
                'minute' => 0,
                'second' => 0),
            $this->cal->prevDay('array'));
    }
    function testThisDay () {
        $this->assertEqual(1, $this->cal->thisDay());
    }
    function testNextDay () {
        $this->assertEqual(2, $this->cal->nextDay());
    }
    function testPrevHour () {
        $this->assertEqual(23, $this->cal->prevHour());
    }
    function testThisHour () {
        $this->assertEqual(0, $this->cal->thisHour());
    }
    function testNextHour () {
        $this->assertEqual(1, $this->cal->nextHour());
    }
    function testPrevMinute () {
        $this->assertEqual(59, $this->cal->prevMinute());
    }
    function testThisMinute () {
        $this->assertEqual(0, $this->cal->thisMinute());
    }
    function testNextMinute () {
        $this->assertEqual(1, $this->cal->nextMinute());
    }
    function testPrevSecond () {
        $this->assertEqual(59, $this->cal->prevSecond());
    }
    function testThisSecond () {
        $this->assertEqual(0, $this->cal->thisSecond());
    }
    function testNextSecond () {
        $this->assertEqual(1, $this->cal->nextSecond());
    }
    function testGetTimeStamp() {
        $stamp = mktime(0, 0, 0, 10, 1, 2003);
        $this->assertEqual($stamp, $this->cal->getTimeStamp());
    }
}

class TestOfMonthWeekdaysBuild extends TestOfMonthWeekdays {
    function TestOfMonthWeekdaysBuild() {
        $this->UnitTestCase('Test of Month_Weekdays::build()');
    }
    function testSize() {
        $this->cal->build();
        $this->assertEqual(35, $this->cal->size());
    }
    function testFetch() {
        $this->cal->build();
        $i=0;
        while ($Child = $this->cal->fetch()) {
            $i++;
        }
        $this->assertEqual(35, $i);
    }
    function testFetchAll() {
        $this->cal->build();
        $children = array();
        $i = 1;
        while ($Child = $this->cal->fetch()) {
            $children[$i] = $Child;
            $i++;
        }
        $this->assertEqual($children,$this->cal->fetchAll());
    }
    function testSelection() {
        include_once CALENDAR_ROOT . 'Day.php';
        $selection = array(new Calendar_Day(2003, 10, 25));
        $this->cal->build($selection);
        $daysInPrevMonth = (0 == CALENDAR_FIRST_DAY_OF_WEEK) ? 3 : 2;
        $end = 25 + $daysInPrevMonth;
        $i = 1;
        while ($Child = $this->cal->fetch()) {
            if ($i == $end) {
                break;
            }
            $i++;
        }
        $this->assertTrue($Child->isSelected());
        $this->assertEqual(25, $Child->day);
    }
    function testEmptyCount() {
        $this->cal->build();
        $empty = 0;
        while ($Child = $this->cal->fetch()) {
            if ($Child->isEmpty()) {
                $empty++;
            }
        }
        $this->assertEqual(4, $empty);
    }
    function testEmptyCount2() {
        $this->cal = new Calendar_Month_Weekdays(2010,3);
        $this->cal->build();
        $empty = 0;
        while ($Child = $this->cal->fetch()) {
            if ($Child->isEmpty()) {
                $empty++;
            }
        }
        $this->assertEqual(4, $empty);
    }
    function testEmptyCount3() {
        $this->cal = new Calendar_Month_Weekdays(2010,6);
        $this->cal->build();
        $empty = 0;
        while ($Child = $this->cal->fetch()) {
            if ($Child->isEmpty()) {
                $empty++;
            }
        }
        $this->assertEqual(5, $empty);
    }
    function testEmptyDaysBefore_AfterAdjust() {
        $this->cal = new Calendar_Month_Weekdays(2004, 0);
        $this->cal->build();
        $expected = (CALENDAR_FIRST_DAY_OF_WEEK == 0) ? 1 : 0;
        $this->assertEqual($expected, $this->cal->tableHelper->getEmptyDaysBefore());
    }
    function testEmptyDaysBefore() {
        $this->cal = new Calendar_Month_Weekdays(2010, 3);
        $this->cal->build();
        $expected = (CALENDAR_FIRST_DAY_OF_WEEK == 0) ? 1 : 0;
        $this->assertEqual($expected, $this->cal->tableHelper->getEmptyDaysBefore());
    }
    function testEmptyDaysBefore2() {
        $this->cal = new Calendar_Month_Weekdays(2010, 6);
        $this->cal->build();
        $expected = (CALENDAR_FIRST_DAY_OF_WEEK == 0) ? 2 : 1;
        $this->assertEqual($expected, $this->cal->tableHelper->getEmptyDaysBefore());
    }
    function testEmptyDaysAfter() {
        $this->cal = new Calendar_Month_Weekdays(2010, 3);
        $this->cal->build();
        $expected = (CALENDAR_FIRST_DAY_OF_WEEK == 0) ? 30 : 31;
        $this->assertEqual($expected, $this->cal->tableHelper->getEmptyDaysAfter());
    }
    function testEmptyDaysAfter2() {
        $this->cal = new Calendar_Month_Weekdays(2010, 6);
        $this->cal->build();
        $expected = (CALENDAR_FIRST_DAY_OF_WEEK == 0) ? 30 : 31;
        $this->assertEqual($expected, $this->cal->tableHelper->getEmptyDaysAfter());
    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = &new TestOfMonthWeekdays();
    $test->run(new HtmlReporter());
    $test = &new TestOfMonthWeekdaysBuild();
    $test->run(new HtmlReporter());
}
?>