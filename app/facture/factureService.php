<?php
include_once ('factureMateriel.php');
include_once ('factureShift.php');
include_once('Credit.php');
include_once ('avanceClient.php');

class FactureService{

    const FACTURE_TYPE = "facture_type";
    const FACTURE_MATERIEL = "facture_materiel";
    const FACTURE_SHIFT = "facture_shift";
    const CREDIT = "credit";
    const AVANCE_CLIENT = "avance_client";
    const COTE = "cote";
    const SEQUENCE = "Sequence";
    const SEQUENCE_FROM_DTO = "sequence";
    const FIRST_SEQUENCE_NUMBER = 0;

    private $Notes;
    private $tps;
    private $tvq;

    function __construct($notes, $tps, $tvq){
        $this->Notes = $notes;
        $this->tps = $tps;
        $this->tvq = $tvq;
        $this->SQL = new SqlClass();
    }

    function generate_blank_facture($facture_dto){

        $facture_information = array(
            "Cote"=>$facture_dto["cote"],
            "Semaine"=>$facture_dto["semaine"],
            "EnDate"=> date_timestamp_get(new DateTime()),
            "Sequence"=>$facture_dto[self::SEQUENCE_FROM_DTO],
        );


        if($facture_dto['taxable']){
            $facture_information['TVQ']=$this->tvq;
            $facture_information['TPS']=$this->tps;
        }

        $facture_class = $this->get_facture_class($facture_dto[self::FACTURE_TYPE]);
        if($facture_dto[self::SEQUENCE_FROM_DTO]==""){
            $facture_information[self::SEQUENCE] = $this->get_next_facture_sequence_when_missing_from_dto($facture_dto, $facture_dto[self::FACTURE_TYPE]);
        }


        return new $facture_class($facture_information);
    }

    private function get_next_facture_sequence_when_missing_from_dto($facture_dto){

        switch ($facture_dto["facture_type"]){
            case self::FACTURE_MATERIEL:
                $next_sequence = $this->get_next_shift_and_materiel_facture_sequence($facture_dto['cote']);
                break;

            case self::FACTURE_SHIFT:
                $next_sequence = $this->get_next_shift_and_materiel_facture_sequence($facture_dto['cote']);
                break;

            case self::CREDIT:
                $next_sequence = $this->get_next_credit_sequence($facture_dto['cote']);
                break;

            case self::AVANCE_CLIENT:
                $next_sequence = $this->get_next_avance_client_sequence($facture_dto['cote']);
                break;

            default:
                throw new ErrorException("le type de facture ".$facture_dto["facture_type"]." n'existe pas");
        }

        return $next_sequence;
    }

    private function get_facture_class($facture_type){

        $facture_class = null;
        switch ($facture_type){

            case self::FACTURE_MATERIEL:
                $facture_class = FactureMateriel::class;
                break;

            case self::FACTURE_SHIFT:
                $facture_class = FactureShift::class;
                break;

            case self::CREDIT:
                $facture_class = Credit::class;
                break;

            case self::AVANCE_CLIENT:
                $facture_class = AvanceClient::class;
                break;

            default:
                throw new ErrorException("le type de facture ".$facture_type." n'existe pas");
        }

        return $facture_class;
    }

    function get_next_credit_sequence($cote){
        return $this->get_last_sequence_for_cote_and_type($cote, self::CREDIT)+1;
    }

    function get_next_avance_client_sequence($cote){
        return $this->get_last_sequence_for_cote_and_type($cote, self::AVANCE_CLIENT)+1;
    }

    function get_next_shift_and_materiel_facture_sequence($cote){
        $last_facture_materiel_sequence = $this->get_last_sequence_for_cote_and_type($cote, self::FACTURE_MATERIEL);
        $last_facture_shift_sequence = $this->get_last_sequence_for_cote_and_type($cote, self::FACTURE_SHIFT);

        return max($last_facture_materiel_sequence, $last_facture_shift_sequence) + 1;
    }

    private function get_last_sequence_for_cote_and_type($cote, $facture_type){
        $facture_class = $this->get_facture_class($facture_type);
        $last_facture_query = $facture_class::get_last_facture_query($cote);;
        $database_information = Facture::define_table_info();
        $this->SQL->Select($last_facture_query);
        $last_facture_sequence = self::FIRST_SEQUENCE_NUMBER;

        if ($this->SQL->NumRow() > 0) {
            $last_facture_response = $this->SQL->FetchArray();
            $last_facture_id = intval($last_facture_response[$database_information['model_table_id']]);
            $last_facture = new $facture_class($last_facture_id);
            $last_facture_sequence = $last_facture->{self::SEQUENCE};
        }

        return $last_facture_sequence;
    }

    private function get_facture_by_cote_sequence_and_type($cote, $sequence, $facture_class){
        $facture_id_query = $facture_class::get_by_cote_and_sequence($cote, $sequence);
        $database_information = Facture::define_table_info();
        $this->SQL->Select($facture_id_query);

        if ($this->SQL->NumRow() > 0) {
            $facture_id_response = $this->SQL->FetchArray();
            $facture_id = intval($facture_id_response[$database_information['model_table_id']]);
            $facture = new $facture_class($facture_id);
        }else{
            throw new UnexpectedValueException();
        }

        return $facture;
    }

    function get_shift_and_materiel_facture_by_cote_and_sequence($cote, $sequence){
        # trouver comment mettre ca clean pcq actuellement c'est moyen
        $facture = null;
        try{
            $facture_materiel_class = $this->get_facture_class(self::FACTURE_MATERIEL);
            $facture = $this->get_facture_by_cote_sequence_and_type($cote, $sequence, $facture_materiel_class);
        }catch(UnexpectedValueException $e){}

        try{
            $facture_shift_class = $this->get_facture_class(self::FACTURE_SHIFT);
            $facture = $this->get_facture_by_cote_sequence_and_type($cote, $sequence, $facture_shift_class);
        }catch(UnexpectedValueException $e){}

        if(is_null($facture)){
            throw new UnexpectedValueException("La facture ".$cote."-".$sequence." n'a pas ete trouvee ");
        }

        return $facture;
    }
}

