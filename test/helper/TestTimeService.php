<?php

include_once('helper/TimeService.php');

class TestTimeService extends PHPUnit_Framework_TestCase{

    const A_DAY = "12";
    const A_MONTH = "7";
    const A_YEAR = "2018";
    const A_TIMESTAMP = "1529812800";
    const A_TIMESTAMP_IN_THE_WEEK = "1593023400"; #24 juin 2020 18h30 (Mercredi)
    const A_DATE_FORMAT = "d-m-Y";
    const A_DATE_FORMAT_USING_LOCALE = "%e %b %g";
    const A_EQUIVALENT_TIMESTAMP_FORMAT = "24-06-2018";
    const A_DAY_OF_WEEK = 2;
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

    function test_givenTimeStamp_whenGetWeekDayThatChangesMonth_thenGetIntegerOfWeekDayOfTheNextMonth(){
        $time_to_test = new datetime();
        $time_to_test->setDate(2018,2,25);
        $time_to_test->setTime(0,0,0);

        $switch_day = $this->time_service->get_week_day_that_changes_month($time_to_test);

        $this->assertEquals(4, $switch_day);
    }

    function test_givenTimestamp_whenFormatTimestamp_thenObtainCorrectDateFormat(){
        $converted_datetime = $this->time_service->format_timestamp(self::A_TIMESTAMP, self::A_DATE_FORMAT);

        $this->assertEquals(self::A_EQUIVALENT_TIMESTAMP_FORMAT, $converted_datetime);
    }

    function test_givenTimestamp_whenGetWeekEndPoints_thenObtain2CorrectDate(){
        $endpoints = $this->time_service->get_week_endpoints_from_timestamp(self::A_TIMESTAMP);

        $this->assertEquals(24, $endpoints["start_of_week"]->format("d"));
        $this->assertEquals(30, $endpoints["end_of_week"]->format("d"));
    }

    function test_givenDateTimeObject_whenFormatDateTimeUsingLocale_thenObtainStringUsingLocale(){
        $datetime = new DateTime();
        $datetime->setDate(2018,10,5);
        $datetime_in_string = $this->time_service->convert_datetime_to_string_using_locale($datetime, self::A_DATE_FORMAT_USING_LOCALE);

        $this->assertEquals(" 5 Oct 18", $datetime_in_string );
    }

    function test_givenWeekAndDay_whenGetDateTimeFromSemaineAndDay_thenGetCorrectDateTimeObject(){
        $day_datetime = $this->time_service->get_datetime_from_semaine_and_day(new DateTime("@".self::A_TIMESTAMP),self::A_DAY_OF_WEEK);

        $this->assertEquals(self::A_DAY_OF_WEEK, intval($day_datetime->format("w")));
    }

    function test_givingATimeStamp_whenGetTimeInstant_thenGetListofSemaineJourDayTimeInSecond(){
        list($semaine, $day, $timeOfDayInSecond) = $this->time_service->getTimeInstant(new DateTime("@".self::A_TIMESTAMP_IN_THE_WEEK));

        $this->assertEquals(1592712000, $semaine);
        $this->assertEquals(3, $day);
        $this->assertEquals(66600, $timeOfDayInSecond);
    }
}
