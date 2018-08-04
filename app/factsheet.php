<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 18/01/18
 * Time: 10:32 PM
 */

class Factsheet extends baseModel
{

    public $End;
    public $Notes;
    public $Start;
    public $Jour;
    public $IDFacture;
    public $IDFactsheet;

    function update_using_next_shift($next_shift){
        $this->End = $next_shift->End;
        $this->Notes = substr($this->Notes,0,-1);
        $employe = new Employee($next_shift->IDEmploye);
        $this->Notes.= "-".$employe->initials().")";
    }

    function update_using_customer_ferie($customer_ferie){
        $associated_facture = new Facture($this->IDFacture);
        if(is_ferie($this->Jour*86400+$associated_facture->Semaine)){
            if($customer_ferie<>1){
                $this->TXH *= $customer_ferie;
                $this->Notes .= " (x".$customer_ferie. HOLIDAY.")";
            }
        }
    }

    function update_for_minimum_4h(){
        if($this->Start==0 and $this->End==14400){
            $this->Notes .= " (Minimum 4h)";
        }
    }

    function add_factshift_to_balance(&$Balance){
        $Balance += round(($this->End - $this->Start)/NB_SECONDS_PER_HOUR*$this->TXH,2);
    }

    static function define_table_info(){
        return array("model_table" => "factsheet",
            "model_table_id" => "IDFactsheet");
    }

    static function define_data_types(){
        return array("IDFactsheet"=>'ID',
        'TXH'=>'float');
    }

}