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

    function __construct($Arg)
    {

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

     function is_connected_after($previous_shift){
         return ($previous_shift->End == $this->Start and $previous_shift->Jour == $previous_shift->Jour);
     }

     function is_shift_assistant(){
        if($this->Assistant==0){
            return false;
        }else{
            return true;
        }
     }

    function generate_log($Action, $Info)
    {
        $log = new LogShift($this, $Action, $Info);
        return $log;
    }

}