<?php
class horaire{

    private $shifts;
    private $days;
    private $sql_connection;
    private $time_service;
    private $working_employees;

    function __construct($time_service, $sql_connection){
        $this->shifts = [];
        $this->days = [];
        $this->working_employees = [];
        $this->sql_connection = $sql_connection;
        $this->time_service = $time_service;
    }

    function add_shift($shift){
        $this->shifts[] = $shift;
        $current_employe = new Employee($shift->IDEmploye);
        $this->add_employe_to_horaire($this, $current_employe);
        if(!key_exists($shift->Jour,$this->days)){
            $this->days[$shift->Jour] = new Horaire($this->time_service, $this->sql_connection);
        }
        $this->add_shift_to_sub_horaire($this->days[$shift->Jour], $shift);
    }

    private function add_employe_to_horaire($horaire, $employe){
        if(!in_array($employe,$horaire->working_employees)){
            $horaire->working_employees[] = $employe;
        }
    }

    private function add_shift_to_sub_horaire($horaire, $shift){
        $horaire->shifts[] = $shift;
        $current_employe = new Employee($shift->IDEmploye);
        $this->add_employe_to_horaire($horaire, $current_employe);
    }

    function get_shifts(){
        return $this->shifts;
    }

    function get_horaire_by_day($day){
        if(key_exists($day,$this->days)){
            return $this->days[$day];
        }else{
            return array();
        }
    }

    function get_free_employees($employee_list){
        $free_employees = array();
        foreach($employee_list as $employee){
            if(!in_array($employee, $this->working_employees)){
                $free_employees[] = $employee;
            }
        }
        return $free_employees;
    }
}