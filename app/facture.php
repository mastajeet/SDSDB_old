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

        foreach($installation_to_bill as $installation){
            $shifts = Shift::find_billable_shift_by_installation($installation->IDInstallation,$_POST['Semaine']);
            $i =0;
            $shift_to_bill = array();
            foreach($shifts as $current_shift){
                $titre = FIRST_LIFEGUARD;
                if($current_shift->is_shift_assistant()) {
                    $titre = SECOND_LIFEGUARD;
                }
                if(isset($last_shift) and $current_shift->is_connected_after($last_shift)){
                    $shift_to_bill[$i-1]['End'] = $current_shift->End;
                    $shift_to_bill[$i-1]['Notes'] = substr($shift_to_bill[$i-1]['Notes'],0,-1);
                    $shift_to_bill[$i-1]['Notes'] .= "-".get_employe_initials($current_shift->IDEmploye).")";
                }else{
                    $shift_to_bill[$i] = array('Start'=>$current_shift->Start,'End'=>$current_shift->End,'Jour'=>$current_shift->Jour,'TXH'=>$current_shift->TXH,'Notes'=>$titre.": ".$installation->Nom." (".get_employe_initials($current_shift->IDEmploye).")",'Ferie'=>$customer->Ferie);
                    $i++;
                }
                $last_shift = $current_shift;
            }

            foreach($shift_to_bill as $v){

                $v['End'] = $v['End'] - bcmod($v['End'],36);
                $v['Start'] = $v['Start'] - bcmod($v['Start'],36);

                if($v['Start']==0 and $v['End']==14400)
                    $v['Notes'] = $v['Notes']." (Minimum 4h)";

                if(is_ferie($v['Jour']*86400+$_POST['Semaine'])){
                    if($v['Ferie']<>1){
                        $v['TXH'] = $v['TXH']*$v['Ferie'];
                        $v['Notes'] = $v['Notes']." (x".$v['Ferie']. HOLIDAY.")";
                    }
                }
                $Req = "INSERT INTO factsheet(`IDFacture`,`Start`,`End`,`Jour`,`TXH`,`Notes`) VALUES(".$IDFacture.",'".$v['Start']."','".$v['End']."','".$v['Jour']."','".$v['TXH']."','".addslashes($v['Notes'])."')";

                $SQL = new sqlclass;
                $SQL->Insert($Req);
            }
            update_facture_balance($IDFacture);
        }
        return $facture;
    }

    static function define_table_info(){
        return array("model_table" => "facture",
        "model_table_id" => "IDFacture");
    }

    static function define_data_types(){
      return array("IDFacture"=>'ID');
    }

}