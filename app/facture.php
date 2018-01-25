<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 18/01/18
 * Time: 9:20 PM
 */

class Facture extends BaseModel
{
    public $credit = false;
    public $materiel = false;
    public $IDFacture;
    public $Semaine;
    public $Factsheet;

    function __construct($Args){
        parent::__construct($Args);
        $this->Factsheet = array();
    }

    static function generate_facture($Cote, $Semaine){
        $bill_information = array(  "Cote"=>$Cote,
                                    "Semaine"=>$Semaine,
                                    "TPS"=>get_vars('TPS'),
                                    "TVQ"=>get_vars('TVQ'),
                                    "Sequence"=>get_last_facture($Cote),
                                    "EnDate"=>time());
        $facture = new Facture($bill_information);
        $facture->save();

        $IDFacture = $facture->IDFacture;
        $customer = customer::find_customer_by_cote($_POST['FORMCote']);
        $installation_to_bill = Installation::get_installations_to_bill($Cote,$Semaine);

        foreach($installation_to_bill as $installation) {
            $shifts = Shift::find_billable_shift_by_installation($installation->IDInstallation, $_POST['Semaine']);

            foreach ($shifts as $current_shift) {
                $current_shift->add_to_facture($facture);
            }

            $customer->update_facture($facture);

            foreach($facture->Factsheet as $v){

                $v->End -= bcmod($v->End,36);
                $v->Start -= bcmod($v->Start,36);

            }
            $facture->save();
            update_facture_balance($IDFacture);
        }
        return $facture;
    }

    function update_balance(){
//        echo "il faudrait que j'implemente ca!";
    }

    function save(){
        $this->update_balance();
        parent::save();
    }


    function add_factsheet(&$factsheet){
        $this->Factsheet[] = $factsheet;
        $this->add_to_updated_values("Factsheet");
    }
    static function define_table_info(){
        return array("model_table" => "facture",
        "model_table_id" => "IDFacture");
    }

    static function define_data_types(){
      return array("IDFacture"=>'ID',
                    "Factsheet"=>'has_many');
    }

}