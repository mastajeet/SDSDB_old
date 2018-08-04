<?php

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

    public function calculate_number_of_weeks_between($week_2_timestamp, $week_1_timestamp){
        $time_delta = date_diff($week_2_timestamp, $week_1_timestamp);
        $number_of_days_in_between = $time_delta->d;
        $number_of_weeks_in_between = floor($number_of_days_in_between / 7);

        return $number_of_weeks_in_between;
    }

    public function get_start_of_week($datetime){
        $new_datetime = new datetime();
        $number_of_days_since_sunday = $datetime->format('w');
        $new_datetime->setDate($datetime->format('Y'),$datetime->format('m'), $datetime->format('j')-$number_of_days_since_sunday);
        $new_datetime->setTime(0,0,0);

        return $new_datetime;
    }
}
