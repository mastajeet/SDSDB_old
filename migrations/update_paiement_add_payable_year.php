<?php
include_once('mysql_class_mtl.php');
include_once('app/BaseModel.php');
include_once('app/payment.php');
include_once('app/facture/facture.php');

$SQL = new SqlClass();
$payments_query = "SELECT * from paiement";

$payments = array();
$SQL->query($payments_query);

while($payment = $SQL->FetchAssoc()){

    $current_payment = new Payment($payment["IDPaiement"]);
    $payment_to_add = array("IDPaiement"=> $current_payment->IDPaiement);

    $paid_facture = $current_payment->get_paid_facture();

    if(count($paid_facture) > 0){
        $last_facture = array_pop($paid_facture);
        $last_facture_semaine = $last_facture->Semaine;
        try{
            $payable_date = new DateTime("@".$last_facture_semaine);

        }catch(Exception $e){
            print_r($last_facture);
        }
    }else{
        $payable_date = new DateTime("@".$payment['Date']);
    }

    $payable_year = date_format($payable_date,"Y");
    $payment_to_add['PayableYear'] = $payable_year;

    $payments[] = $payment_to_add;
}

foreach($payments as $current_payment){
    $payments_query = "UPDATE paiement SET PayableYear = ".$current_payment['PayableYear']." where IDPaiement = ".$current_payment["IDPaiement"];
    if(!$SQL->Update($payments_query))  {
        print_r($SQL->error_message);
        print("<br>");
    }else{
        print($payments_query."<br>");
    };

}
