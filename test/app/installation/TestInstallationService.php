<?php

include_once('app/installation/InstallationService.php');
include_once('app/installation/connector/localDBConnector.php');

use installation\InstallationService;
use installation\localDBConnector;

class TestInstallationService extends PHPUnit_Framework_TestCase
{

    private $installationService;
    /**
     * @before
     */
    function setup_tested_instance(){
        $dataSource = new localDBConnector(SqlClass::class);
        $this->installationService = new InstallationService(0, $dataSource);
    }

    function test_givenSaisonActif_whenGenerateSelectInstallationList_thenGetOnlyActifandEnSaison()
    {
        $installationList = $this->installationService->getInstallationSelectList(1,1);
        $this->assertCount(16, $installationList);
    }

    function test_givenPasSaisonPasActif_whenGenerateSelectInstallationList_thenGetAllInstallations()
    {
        $installationList = $this->installationService->getInstallationSelectList(0,0);
        $this->assertCount(19, $installationList);
    }

    function test_givenSaisonActif_whenGenerateListOfCotes_thenObtainCoteOfActiveInstallations()
    {
        $installationList = $this->installationService->getInstallationListInStringByCote('CT1', 1, 1);
        $this->assertEquals('cote_1_installation_1, cote_1_installation_2', $installationList);
    }

    function test_whenGetInstallationCote_thenObtainCoteOfActiveInstallations(){
        $installationCoteList = $this->installationService->getInstallationsCotes();
        $this->assertCount(14, $installationCoteList);
    }

}
