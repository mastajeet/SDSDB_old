<?php

include_once ('app/facture/factureService.php');

class TestFactureService extends PHPUnit_Framework_TestCase{

    private $facture_service;
    private $facture_dto;
    const UNE_COTE = "TFS";
    const UN_NUMERO_SEQUENTIEL = 3;
    const UNE_SEMAINE = 1547355600;
    const TAXABLE = true;


    /**
     * @before
     */
    function setUp(){
        $this->facture_service = new FactureService("",0,0);
        $this->facture_dto = array(
            "cote"=>self::UNE_COTE,
            "semaine"=>self::UNE_SEMAINE,
            "sequence"=>self::UN_NUMERO_SEQUENTIEL,
            "taxable"=>self::TAXABLE
        );
    }

    function test_givenMaterielFlag_whenCreateFacture_thenMaterielFactureIsReturned(){
        $this->facture_dto["facture_type"] = "facture_materiel";

        $facture = $this->facture_service->generate_blank_facture($this->facture_dto);

        $this->assertEquals('FactureMateriel', get_class($facture));
    }

    function test_givenCreditFlag_whenCreateFacture_thenCreditIsReturned(){
        $this->facture_dto["facture_type"] = "credit";

        $facture = $this->facture_service->generate_blank_facture($this->facture_dto);

        $this->assertEquals('Credit', get_class($facture));
    }

    function test_givenAvanceClientFlag_whenCreateFacture_thenAvanceClientIsReturned(){
        $this->facture_dto["facture_type"] = "avance_client";

        $facture = $this->facture_service->generate_blank_facture($this->facture_dto);

        $this->assertEquals('AvanceClient', get_class($facture));
    }

    function test_givenShiftFlag_whenCreateFacture_thenShiftFactureIsReturned(){
        $this->facture_dto["facture_type"] = "facture_shift";

        $facture = $this->facture_service->generate_blank_facture($this->facture_dto);

        $this->assertEquals('FactureShift', get_class($facture));
    }

    function test_whenGetNextShiftAndMaterielFactureSequence_thenGetSequenceToUse(){
        $next_sequence = $this->facture_service->get_next_shift_and_materiel_facture_sequence(self::UNE_COTE);

        $this->assertEquals(5, $next_sequence);
    }

    function test_whenGetFactureShiftAndMaterielByCoteAndSequence_thenGetCorrectFacture(){
        $facture = $this->facture_service->get_shift_and_materiel_facture_by_cote_and_sequence(self::UNE_COTE, self::UN_NUMERO_SEQUENTIEL);

        $this->assertEquals(3002, $facture->IDFacture);
    }
}
