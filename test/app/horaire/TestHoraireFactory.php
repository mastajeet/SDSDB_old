<?php

include_once ('app/horaire/horaireFactory.php');

class TestHoraireFactory extends PHPUnit_Framework_TestCase{

    private $A_DAY_WITH_SHIFTS;

    /**
     * @before
     */
    function setup_tested_instance(){
        $this->A_DAY_WITH_SHIFTS = new datetime("2017-06-11T00:00:00.000000Z");
        $this->horaire_factory = new HoraireFactory(new TimeService(), new SqlClass());
    }

    function test_givenDateTime_whenGenerateHoraireForOneDay_thenGetAllShiftOfThatDayIntoHoraire(){
        $horaire = $this->horaire_factory->generate_horaire_for_one_day($this->A_DAY_WITH_SHIFTS);
        $this->assertEquals(1, sizeof($horaire->get_shifts()));
        $this->assertEquals(1, sizeof($horaire->get_horaire_by_day(0)->get_shifts()));
    }
}
