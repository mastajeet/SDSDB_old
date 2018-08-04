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

    public function get_start_of_month($datetime){
        $current_month = $datetime->format('m');

        $current_datetime = new DateTime();
        $current_datetime->setDate($datetime->format('Y'),$current_month, 1);
        $current_datetime->setTime(0,0, 0);

        return $current_datetime;
    }

    public function get_weeks_of_month($datetime){
        $weeks_of_month = array();
        $current_month = $datetime->format('m');
        $current_datetime = $this->get_start_of_month($datetime);
        $current_datetime = $this->get_start_of_week($current_datetime);

        do{
            $weeks_of_month[] = $current_datetime;
            $current_datetime = clone $current_datetime;
            $current_datetime->add(new DateInterval("P7D"));

        }while($current_datetime->format('m')==$current_month);

        return $weeks_of_month;
    }

    public function get_switch_month_week_day($datetime){
        $start_of_week = $this->get_start_of_week($datetime);
        $initial_month = $start_of_week->format('m');
        $current_day = clone $start_of_week;
        $switch_day = 0;
        do{
            $current_day->add(new DateInterval("P1D"));
            $switch_day++;
            if($switch_day>7){
                throw new UnexpectedValueException(NO_CHANGE_OF_MONTH);
            }
        }while($current_day->format('m')==$initial_month);

        return $switch_day;
    }
}

