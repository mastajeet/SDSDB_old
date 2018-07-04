<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 04/07/18
 * Time: 9:02 AM
 */

class TimeService {

    public function get_today_timestamp(){
        $now = new DateTime();
        $truncated_datetime = $now->setTime(0,0,0);

        return($truncated_datetime->getTimestamp());
    }

    public function get_date_timestamp($month, $day, $year){
        $now = new DateTime();
        $correct_date = $now->setDate($year,$month,$day);
        $correct_date_and_time = $correct_date->setTime(0,0,0);

        return($correct_date_and_time->getTimestamp());
    }
}