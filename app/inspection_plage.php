<?php
include_once('base_model.php');
include_once('inspection.php');
class inspection_plage extends inspection
{


    function select_all_query(){
        return "SELECT * FROM inspection WHERE IDInspection = ";
    }





}