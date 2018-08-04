<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 04/07/18
 * Time: 8:51 AM
 */
include_once('helper/TimeService.php');

class TestTimeService extends PHPUnit_Framework_TestCase{

    const A_DAY = "12";
    const A_MONTH = "7";
    const A_YEAR = "2018";

    /**
     * @before
     */
    function setUp_time_values(){
        $this->today = new DateTime();
        $this->time_service = new TimeService();
    }

    function test_whenGetTodayTimestamp_thenGetTodayTimestampAtMidnight(){
        $today_timestamp = $this->time_service->get_today_timestamp();

        $this->assertEquals($this->today->format('d'), date("d", $today_timestamp));
        $this->assertEquals($this->today->format('m'), date("m", $today_timestamp));
        $this->assertEquals($this->today->format('Y'), date("Y", $today_timestamp));
        $this->assertEquals(0, date("G", $today_timestamp));
        $this->assertEquals(0, date("i", $today_timestamp));
        $this->assertEquals(0, date("s", $today_timestamp));
    }

    function test_whenGenerateDateTimestamp_thenGetDateTimestampAtMidnight(){
        $date_timestamp = $this->time_service->get_date_timestamp(self::A_MONTH, self::A_DAY, self::A_YEAR);

        $this->assertEquals(self::A_DAY, date("d", $date_timestamp));
        $this->assertEquals(self::A_MONTH, date("m", $date_timestamp));
        $this->assertEquals(self::A_YEAR, date("Y", $date_timestamp));
        $this->assertEquals(0, date("G", $date_timestamp));
        $this->assertEquals(0, date("i", $date_timestamp));
        $this->assertEquals(0, date("s", $date_timestamp));
    }

    function test_givenTwoCorrectTimeStamp_whenGetWeekDifference_thenGetIntegerValueOfNumberOfWeeks(){

        $week_1_timestamp = new DateTime();
        $week_1_timestamp->setTimestamp(1532232000);
        $week_2_timestamp = new DateTime();
        $week_2_timestamp->setTimestamp(1532836800);

        $number_of_weeks_in_between = $this->time_service->calculate_number_of_weeks_between($week_1_timestamp, $week_2_timestamp);

        $this->assertEquals(1, $number_of_weeks_in_between);
    }

    function test_givenTimeStampWithDaylightSavingChange_whenGetWeekDifference_thenGetCorrectIntegerValueOfNumberOfWeeks(){

        $week_1_timestamp = new DateTime();
        $week_1_timestamp->setTimestamp(1520139600);
        $week_2_timestamp = new DateTime();
        $week_2_timestamp->setTimestamp(1521345600);

        $number_of_weeks_in_between = $this->time_service->calculate_number_of_weeks_between($week_1_timestamp, $week_2_timestamp);

        $this->assertEquals(2, $number_of_weeks_in_between);
    }

    function test_givenTimeStampWithDaylightSavingChange2_whenGetWeekDifference_thenGetCorrectIntegerValueOfNumberOfWeeks(){

        $week_1_timestamp = new DateTime();
        $week_1_timestamp->setTimestamp(1540699200);
        $week_2_timestamp = new DateTime();
        $week_2_timestamp->setTimestamp(1541912400);

        $number_of_weeks_in_between = $this->time_service->calculate_number_of_weeks_between($week_1_timestamp, $week_2_timestamp);

        $this->assertEquals(2, $number_of_weeks_in_between);
    }

    function test_givenTimeStampOnSundayAtMidnight_whenGetStartOfWeek_thenGetTheSameDateTime(){
        $time_to_test = new datetime();
        $time_to_test->setDate(2018,7,8);
        $time_to_test->setTime(0,0,0);

        $start_of_week = $this->time_service->get_start_of_week($time_to_test);

        $this->assertEquals($start_of_week, $time_to_test);
    }

    function test_givenTimeStampOMondayAtNoon_whenGetStartOfWeek_thenGetTheSundayAtMidnight(){
        $time_to_test = new datetime();
        $time_to_test->setDate(2018,7,9);
        $time_to_test->setTime(15,1,1);

        $start_of_week = $this->time_service->get_start_of_week($time_to_test);

        $expected_time = new datetime();
        $expected_time->setDate(2018,7,8);
        $expected_time->setTime(0,0,0);
        $this->assertEquals($expected_time, $start_of_week);
    }

    function test_givenTimeStampDuringWeekOfDayLightSaving_whenGetStartOfWeek_thenGetTheSundayAtMidnight(){
        $time_to_test = new datetime();
        $time_to_test->setDate(2018,3,12);
        $time_to_test->setTime(0,0,0);

        $start_of_week = $this->time_service->get_start_of_week($time_to_test);

        $expected_time = new datetime();
        $expected_time->setDate(2018,3,11);
        $expected_time->setTime(0,0,0);
        $this->assertEquals($expected_time, $start_of_week);
    }

    function test_givenTimeStamp_whenGetWeeksOfMonth_thenGetArrayOfDateTimeOfAllStartOfWeek(){
        $time_to_test = new datetime();
        $time_to_test->setDate(2018,3,12);
        $time_to_test->setTime(0,0,0);

        $weeks_of_month = $this->time_service->get_weeks_of_month($time_to_test);

        $weeks_to_add = array();
        $weeks_to_add[] = '2,25';
        $weeks_to_add[] = '3,4';
        $weeks_to_add[] = '3,11';
        $weeks_to_add[] = '3,18';
        $weeks_to_add[] = '3,25';
        $expected_week = array();
        foreach($weeks_to_add as $week){
            $splitted_weak = explode(',', $week);
            $time_to_add = new datetime();
            $time_to_add->setDate(2018,$splitted_weak[0] ,$splitted_weak[1]);
            $time_to_add->setTime(0,0,0);
            $expected_week[] = $time_to_add;
        }
        $this->assertEquals($expected_week, $weeks_of_month);
    }

    function test_givenTimeStamp_whenGetSwitchMonthWeekDay_thenGetIntegerOfWeekDayOfTheNextMonth(){
        $time_to_test = new datetime();
        $time_to_test->setDate(2018,2,25);
        $time_to_test->setTime(0,0,0);

        $switch_day = $this->time_service->get_switch_month_week_day($time_to_test);

        $this->assertEquals(4, $switch_day);
    }
}