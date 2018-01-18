<?php
include_once('base_model.php');

const NO_CLIENT_ASSOCIATED_WITH_COTE = "Aucun client n'est associe à la cote";

class Customer extends base_model
{
    public $IDClient;
    public $Ferie;

    function define_table_info(){
        $this->model_table = 'client';
        $this->model_table_id = 'IDClient';
    }

    function calculate_billable_hours($start,$end,$isFerie){


    }

    static function find_customer_by_cote($cote){
        $sql = new SqlClass();
        $query = "SELECT client.IDClient from client JOIN installation on installation.IDClient = client.IDClient WHERE installation.Cote ='".$cote."'";
        $sql->Select($query);
        if($sql->NumRow()==0){
            throw new InvalidArgumentException(NO_CLIENT_ASSOCIATED_WITH_COTE." ".$cote);
        }
        $customer_id = $sql->Get_first();
        $sql->CloseConnection();

        return new Customer($customer_id['IDClient']);
    }

}