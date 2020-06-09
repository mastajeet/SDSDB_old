<?php
include_once('app/dossier_facturation/customerTransaction.php');


class Invoice extends BaseModel implements customerTransaction
{
    public $Credit;
    public $Debit;
    public $Materiel;
    public $Interest;
    public $AvanceClient;
    public $Paye;
    public $IDFacture;
    public $Sequence;
    public $Semaine;
    public $TVQ;
    public $TPS;
    public $STotal;
    public $Factsheet;
    public $EnDate;
    public $Cote;
    public $BonAchat;
    public $Notes;

    function __construct($Args){
        parent::__construct($Args);
        $this->Factsheet = array();
    }

    static function get_last_facture_query($cote){
        throw new NotImplementedException();
    }

    static function get_by_cote_and_sequence($cote, $sequence){
        throw new NotImplementedException();
    }

    function update_balance(){
        $balance = 0;
        foreach($this->Factsheet as $factsheet){
            $factsheet->add_factshift_to_balance($balance);
        }
        $this->STotal = $balance;
    }

    function save(){
        //stu moi ou ca va decalicer quand on va editer qqch dans la invoice... au moins on peut rien modifier a part les shifts dedans....
        $this->updated_values[] = "STotal";
        $this->update_balance();
        parent::save();
    }

    function get_payment($payments){
        $payment_that_paid_this_facture = null;
        foreach($payments as $id_payment => $payment){
            if($payment->paid_facture($this)){
                $payment_that_paid_this_facture = $payment;
            }
        }

        if(is_null($payment_that_paid_this_facture)){
            throw new RuntimeException("Can't find payment for paid invoice ".$this->Cote."-".$this->Sequence);
        }

        return $payment_that_paid_this_facture;
    }

    function get_balance(){
        $balance= Array("sub_total"=>0, "tps"=>0, "tvq"=>0, "total"=>0);

        $balance["sub_total"] = $this->STotal;
        $balance["tps"] = round($balance["sub_total"] * $this->TPS, 2);
        $balance["tvq"] = round(($balance["sub_total"]+$balance["tps"]) * $this->TVQ, 2);
        $balance["total"] = $balance["sub_total"] + $balance["tps"] + $balance["tvq"];

        return $balance;
    }

    function is_credit(){
        return $this->Credit==1;
    }

    function is_debit(){
        return $this->Debit==1;
    }

    function is_avance_client(){
        return $this->AvanceClient==1;
    }

    function is_paid(){
        return $this->Paye==1;
    }

    # This function is overloaded in the specific class. Different behavior...
    function is_shift(){
        return false;
    }

    function mark_paid(){
        $this->Paye=1;
    }

    function mark_unpaid(){
        $this->Paye=0;
    }

    function is_materiel(){
        return $this->Materiel==1;
    }

    function is_interest(){
        return $this->Interest==1;
    }

    function is_utilise(){
        return $this->Utilise==1;
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
        return array("IDFacture" => 'ID',
            'TPS'=>'float',
            'TVQ'=>'float',
            'Notes'=>'string',
            "Factsheet" => 'has_many');
    }

    function get_customer_transaction()
    {
        $balance = $this->get_balance();
        $detail = $this->Cote."-".$this->Sequence;
        if($this->is_materiel()){
            $detail .= " (Matériel)";
        }
        return array("date"=>new DateTime("@".$this->EnDate),
                "notes"=>$detail,
                "debit"=>$balance['total']*$this->is_debit(),
                "credit"=>$balance['total']*$this->is_credit());
    }
}
