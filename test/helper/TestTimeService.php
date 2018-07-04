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
}