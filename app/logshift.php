<?php
include_once("./app/shift.php");

class LogShift extends Shift
{

    Public $Action;
    Public $RequestURI;
    Public $DateAction;
    Public $IDEmployeAction;
    Public $IP;
    Public $OrdinateurNom;

    function __construct(Shift $Shift, $Action)
    {
        castFromParent($this, $Shift);
        $this->Action = $Action;
        $this->OrdinateurNom = gethostname();
        $this->RequestURI = $_SERVER['REQUEST_URI'];
        $this->DateAction = time();
        $this->IDEmployeAction = $_COOKIE['IDEmploye'];
        $this->IP = $_SERVER['REMOTE_ADDR'];

        $this->save();
    }

    function save()
    {
        $InsertReq = "

        INSERT INTO logshift (
            `IDShift` ,
            `IDInstallation` ,
            `IDEmploye` ,
            `TXH` ,
            `Salaire` ,
            `Start` ,
            `End` ,
            `Jour` ,
            `Semaine` ,
            `Assistant` ,
            `Commentaire` ,
            `Warn` ,
            `Confirme` ,
            `Empconf` ,
            `Facture` ,
            `Paye` ,
            `Action` ,
            `DateAction` ,
            `RequestURI` ,
            `IDEmployeAction` ,
            `IP` ,
            `OrdinateurNom`
        ) VALUES(
            " . $this->IDShift . "," . $this->IDInstallation . "
            ," . $this->IDEmploye . "
            ," . $this->TXH . "
            ," . $this->Salaire . "
            ," . $this->Start . "
            ," . $this->End . "
            ," . $this->Jour . "
            ," . $this->Semaine . "
            ," . $this->Assistant . "
            ,'" . addslashes($this->Commentaire) . "'
            ,'" . addslashes($this->Warn) . "'
            ," . $this->Confirme . "
            ," . $this->Empconf . "
            ," . $this->Facture . "
            ," . $this->Paye . "
            ,'" . addslashes($this->Action) . "'
            ," . $this->DateAction . "
            ,'" . addslashes($this->RequestURI) . "'
            ," . $this->IDEmployeAction . "
            ,'" . addslashes($this->IP) . "'
            ,'" . addslashes($this->OrdinateurNom) . "'
        )";
        $SQL = new sqlclass();
        $SQL->Insert($InsertReq);

    }
}
