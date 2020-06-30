<?PHP
include_once('BaseModel.php');


class Shift extends BaseModel
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
    public $timeService;


    function __construct($Arg = null, $timeService){
        $this->timeService = $timeService;
        parent::__construct($Arg);
    }


    function is_connected_after($PreviousFactsheet){
        if($PreviousFactsheet){
            return ($PreviousFactsheet->End == $this->Start and $PreviousFactsheet->Jour == $this->Jour);
        }
    }

     function is_shift_assistant(){

        if($this->Assistant==0){
            return false;
        }else{
            return true;
        }
     }

    function generate_log($Action, $Info){
        $log = new LogShift($this, $Action, $Info);
        return $log;
    }

    function add_to_facture(&$Facture){

        $titre = FIRST_LIFEGUARD;
        if($this->is_shift_assistant()) {
            $titre = SECOND_LIFEGUARD;
        }
        if($this->is_connected_after(end($Facture->Factsheet))){
            end($Facture->Factsheet)->update_using_next_shift($this);
        }else{
            $relatedInstallation = new Installation($this->IDInstallation);
            $employee = new Employee($this->IDEmploye);
            $jourFromFactureSemaine = $this->calculate_day_since_semaine($Facture);
            $FactsheetValues = array('IDFacture'=>$Facture->IDFacture,'Start'=>$this->Start,'End'=>$this->End,'Jour'=>$jourFromFactureSemaine,'TXH'=>$this->TXH,'Notes'=>$titre.": ".$relatedInstallation->Nom." (".$employee->initials().")");
            $Facture->addInvoiceItem(new TimedInvoiceItem($FactsheetValues));
        }

        $this->Facture=True;
        $this->save();
    }

    function calculate_day_since_semaine($facture){

        $week_1_timestamp = new DateTime();
        $week_1_timestamp->setTimestamp($this->Semaine);
        $week_2_timestamp = new DateTime();
        $week_2_timestamp->setTimestamp($facture->Semaine);


        $number_of_weeks_between = $this->timeService->calculate_number_of_weeks_between($week_1_timestamp, $week_2_timestamp);
        $number_of_days_between = $number_of_weeks_between *7 + $this->Jour;

        return($number_of_days_between);
    }

    static function define_table_info(){
        return array("model_table" => "shift",
            "model_table_id" => "IDShift");
    }

    static function define_data_types(){
        return array("IDShift"=>'ID',
            'TXH'=>'float',
            'Salaire'=>'float',
            'timeService'=>'service'
        );
    }

    static function getAllShiftsRunningAtAnInstant($datetime, TimeService $time_service)
    {
        $sql_class = new SqlClass();

        list($semaine, $day, $time_instant) = $time_service->getTimeInstant($datetime);
        $table_info = self::define_table_info();
        $query = "SELECT ".$table_info["model_table_id"]." from ".$table_info["model_table"]." WHERE Semaine=".$semaine." and Jour=".$day." and Start <= ".$time_instant." and End >= ".$time_instant;

        $sql_class->Select($query);
        $shifts = array();
        while($shift_record = $sql_class->FetchAssoc())
        {
            $shift_id = $shift_record["IDShift"];
            $shifts[$shift_id] = new Shift($shift_id, $time_service);
        }

        return $shifts;
    }

    function getWorkingEmployee()
    {
        return new Employee($this->IDEmploye);
    }

}
