<?php
include_once('BaseModel.php');


class Customer extends BaseModel
{
    public $IDClient;
    public $Ferie;

    static function define_table_info(){
        return array("model_table" => 'client',
        "model_table_id" => 'IDClient');
    }

    static function find_customer_by_cote($cote){
        $sql = new SqlClass();
        $query = "SELECT client.IDClient from client JOIN installation on installation.IDClient = client.IDClient WHERE installation.Cote ='".$cote."'";
        $sql->Select($query);
        if($sql->NumRow()==0){
            throw new InvalidArgumentException(NO_CLIENT_ASSOCIATED_WITH_COTE." ".$cote);
        }
        $customer_id = $sql->FetchArray()['IDClient'];

        return new Customer($customer_id);
    }

    function update_facture(&$facture){
        foreach ($facture->Factsheet as $factsheet){
            $factsheet->update_using_customer_ferie($this->Ferie);
        }
    }

    private function get_new_facture_sequence($Facture){
        $next_sequence = $Facture->Sequence;
        $next_sequence++;
        return $next_sequence;
    }

    static function generate_facture_hebdomadaire_shifts($Cote, $Semaine){

        $customer = customer::find_customer_by_cote($Cote);
        $last_facture = Facture::get_last_for_cote($Cote);
        $new_facture_sequence = $customer->get_new_facture_sequence($last_facture);

        $facture_information = array(  "Cote"=>$Cote,
            "Semaine"=>$Semaine,
            "TPS"=>get_vars('TPS'),
            "TVQ"=>get_vars('TVQ'),
            "Sequence"=>$new_facture_sequence,
            "EnDate"=>time());
        $facture = new Facture($facture_information);
        $facture->save();

        $installation_to_bill = Installation::get_installations_to_bill($Cote,$Semaine);

        foreach($installation_to_bill as $installation) {
            $shifts = Shift::find_billable_shift_by_installation($installation->IDInstallation, $Semaine);

            foreach ($shifts as $current_shift) {
                $current_shift->add_to_facture($facture);
                $current_shift->Facture=True;
                $current_shift->save();
            }
            $customer->update_facture($facture);
            $facture->save();
        }

        return $facture;
    }

}