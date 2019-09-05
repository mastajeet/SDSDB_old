<?php
include_once('app/shift.php');
include_once('app/horaire/horaire.php');

class HoraireFactory
{
    private $time_service;
    private $sql_connection;

    function __construct($time_service, $sql_connection){
        $this->time_service = $time_service;
        $this->sql_connection = $sql_connection;
    }

    function generate_horaire_for_one_day($datetime){
        $horaire = new Horaire($this->time_service, $this->sql_connection);
        $semaine = $this->time_service->get_start_of_week($datetime);
        $semaine_timestamp = $semaine->getTimestamp();
        $shifts_query = "SELECT IDShift FROM shift where Semaine = {$semaine_timestamp}";
        $this->sql_connection->select($shifts_query);
        while($shift_record = $this->sql_connection->FetchAssoc()){
            $horaire->add_shift(new Shift($shift_record['IDShift'],$this->time_service ));
        }

        return $horaire;
    }
}

