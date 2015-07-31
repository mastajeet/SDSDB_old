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

    function generate_log($Action, $Info)
    {
        $log = new LogShift($this, $Action, $Info);
        return $log;
    }

}