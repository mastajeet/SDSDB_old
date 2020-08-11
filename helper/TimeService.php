<?php

class TimeService {

    public function get_today_timestamp(){
        $now = new DateTime();
        $truncated_datetime = $now->setTime(0,0,0);

        return($truncated_datetime->getTimestamp());
    }

    public function get_datetime_from_semaine_and_day($datetime, $day){
        $day_datetime = $datetime->add(new DateInterval("P{$day}D"));

        return $day_datetime;
    }

    public function get_datetime($month, $day, $year){
        $now = new DateTime();
        $correct_date = $now->setDate($year, $month, $day);
        $correct_date_and_time = $correct_date->setTime(0, 0, 0);

        return ($correct_date_and_time);
    }

    public function get_date_timestamp($month, $day, $year){
        $correct_date_and_time= TimeService::get_datetime($month, $day, $year);

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

    public function get_week_day_that_changes_month($datetime){
        $start_of_week = $this->get_start_of_week($datetime);
        $initial_month = $start_of_week->format('m');
        $current_day = clone $start_of_week;
        $switch_day = 0;

        if($start_of_week->format('d')==1){
            return 0;
        }else{
            do{
                $current_day->add(new DateInterval("P1D"));
                $switch_day++;
                if($switch_day>7){
                    throw new UnexpectedValueException(NO_CHANGE_OF_MONTH);
                }
            }while($current_day->format('m')==$initial_month);
        }

        return $switch_day;
    }

    public function format_timestamp($timestamp, $format){
        $datetime =  new DateTime("@".$timestamp);
        $converted_timestamp = $datetime->format($format);

        return $converted_timestamp;
    }

    public function get_week_endpoints_from_timestamp($timestamp){
        $datetime =  new DateTime("@".$timestamp);
        $start_of_week = self::get_start_of_week($datetime);
        $end_of_week = new DateTime("@".$timestamp);
        $end_of_week->modify('+6 days');
        $end_of_week->setTime(23,59,59);

        return ["start_of_week"=>$start_of_week, "end_of_week"=>$end_of_week];
    }

    public function convert_datetime_to_string_using_locale($datetime, $format){
        return strftime($format, $datetime->getTimestamp());

    }

    public function getTimeInstant($datetime_object)
    {
        $semaine = $this->get_start_of_week($datetime_object)->getTimestamp();
        $day = date_format($datetime_object, "N") % 7;
        $hour = date_format($datetime_object, "H");
        $minute = date_format($datetime_object, "i");
        $time_instant = ($hour * 60 + $minute) * 60;
        return array($semaine, $day, $time_instant);
    }

    public function getNumberedDayOfWeekArray(){
        return array(
            "0"=>"Dimanche",
            "1"=>"Lundi",
            "2"=>"Mardi",
            "3"=>"Mercredi",
            "4"=>"Jeudi",
            "5"=>"Vendredi",
            "6"=>"Samedi",
        );
    }

    public function getNumberedDayOfMonthArray($beginning_of_month_datetime){
        $initial_month = $beginning_of_month_datetime->format('n');
        $current_day = $beginning_of_month_datetime->format('w');
        $current_datetime = clone $beginning_of_month_datetime;
        $day_of_month_array = array();
        do{
            $day_of_month_array[$current_day] = $current_datetime->format('j');
            $current_day++;
        }while($current_datetime->add(new DateInterval("P1D"))->format('n')==$initial_month);

        return $day_of_month_array;

    }
}

