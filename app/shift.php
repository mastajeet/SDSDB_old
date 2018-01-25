<?PHP

class Shift
{
    public $IDShift;
    public $IDInstallation;
    public $IDEmploye;
    public $TXH;
    public $Salaire;
    public $Start;
    public $End;
    public $Jour;
    public $Semaine;
    public $Assistant;
    public $Commentaire;
    public $Warn;
    public $Confirme;
    public $Empconf;
    public $Facture;
    public $Paye;

    function __construct($Arg){

        if (is_null($Arg)) {
            return FALSE;
        }
        if (is_numeric($Arg)) {
            //Assuming ID, search for ID
            $SQL = new sqlclass();
            $SQL->SELECT("SELECT * FROM shift WHERE IDShift = " . $Arg);
            $Req = $SQL->FetchArray();
            foreach ($Req as $Key => $val) {
                $this->$Key = $val;
            }
            $SQL->CloseConnection();
        }
    }

    static function find_billable_shift_by_installation($IDInstallation, $Semaine){

        $sql = new SqlClass();
        $Req = "SELECT shift.IDShift FROM shift JOIN installation JOIN client on shift.IDInstallation = installation.IDInstallation AND client.IDClient = installation.IDClient WHERE shift.IDInstallation = ".$IDInstallation." AND Semaine=".$Semaine." ORDER BY installation.Nom ASC, Jour ASC, shift.Assistant ASC, Start ASC";
        $sql->SELECT($Req);
        $shifts  = array();
        while($shift_result = $sql->FetchArray()){
            $shifts[] = new Shift($shift_result['IDShift']);
        }

        return $shifts;
    }

     function is_connected_after($PreviousShift){

        if($PreviousShift){
         return ($PreviousShift->End == $this->Start and $PreviousShift->Jour == $PreviousShift->Jour);
        }
    }

     function is_shift_assistant(){

        if($this->Assistant==0){
            return false;
        }else{
            return true;
        }
     }

     function add_to_facture(&$Facture){

         $titre = FIRST_LIFEGUARD;
         if($this->is_shift_assistant()) {
             $titre = SECOND_LIFEGUARD;
         }
         if($this->is_connected_after(end($Facture->Factsheet))){
            end($Facture->Factsheet)->update_using_next_shift($this);
         }else{
             $RelatedInstallation = new Installation($this->IDInstallation);
             $FactsheetValues = array('IDFacture'=>$Facture->IDFacture,'Start'=>$this->Start,'End'=>$this->End,'Jour'=>$this->Jour,'TXH'=>$this->TXH,'Notes'=>$titre.": ".$RelatedInstallation->Nom." (".get_employe_initials($this->IDEmploye).")");
             $Facture->add_factsheet(new Factsheet($FactsheetValues));
         }
     }

    function generate_log($Action, $Info){
        $log = new LogShift($this, $Action, $Info);
        return $log;
    }
}
