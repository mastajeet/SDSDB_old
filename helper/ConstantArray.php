<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 05/06/18
 * Time: 9:59 AM
 */

class ConstantArray
{
    static function get_installation_type_kvp(){
        $installation_type_kvp = array('I'=>'Intérieure','IS'=>'Intérieure + Spa','E'=>'Extérieure','ES'=>'Extérieure + Spa','EP'=>'Extérieure + Patogeoire','P'=>'Plage');

        return $installation_type_kvp;
    }

    static function get_installation_parking_type_kvp(){
        $installation_parking_type_kvp = array('DPG' => 'Disponible sur place - Gratuit', 'DPP' => 'Disponible sur place - Payant', 'DRG' => 'Disponible dans les rues - Gratuit', 'DRP' => 'Disponible dans les rues - Payant', 'ND' => 'Non-Disponible');
        return $installation_parking_type_kvp;
    }

    static function get_month_kvp(){
        $month_kvp = array(1=>"Janvier",
            2=>"Février",
            3=>"Mars",
            4=>"Avril",
            5=>"Mai",
            6=>"Juin",
            7=>"Juillet",
            8=>"Août",
            9=>"Septembre",
            10=>"Octobre",
            11=>"Novembre",
            12=>"Décembre "
        );

        return $month_kvp;

    }
}