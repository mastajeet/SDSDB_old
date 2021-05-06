<?php
namespace installation;

include_once('app/installation/connector/InstallationDataSourceInterface.php');

class localDBConnector implements InstallationDataSourceInterface
{
    private $connectorClass;

    function __construct($connectorClass)
    {
        $this->connectorClass = $connectorClass;
    }

    public function getInstallationSelectList($company, $isActive, $inSession)
    {
        $InstallationReq = $this->buildSelectInstallationQuery($isActive, $inSession);
        return $this->buildInstallationListFromQuery($InstallationReq);
    }

    public function getInstallationListByCote($company, $cote, $isActive, $inSession)
    {
        $selectInstallationByCoteQuery = "SELECT IDInstallation, Nom FROM installation WHERE `Cote` = '".$cote."' AND ".$isActive." AND Actif=".$inSession." ORDER BY Nom ASC";
        return $installationList = $this->buildInstallationListFromQuery($selectInstallationByCoteQuery);
    }

    public function getActiveInstallationsCotes()
    {
        $selectInstallationsCotesQuery = "SELECT distinct Cote FROM installation WHERE Actif ORDER BY Cote ASC";
        $sqlClass =  new $this->connectorClass();
        $sqlClass->Select($selectInstallationsCotesQuery);
        $coteList = [];
        while($cursor = $sqlClass->FetchAssoc()){
            $coteList[] = $cursor['Cote'] ;
        }

        return $coteList;
    }

    public function getInstallationCotesToBill($company, $weekInTimestamp)
    {
        $sqlClass =  new $this->connectorClass();
        $Req = "SELECT Cote, sum(Facture) as isBilled FROM shift LEFT JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE `Semaine`=".$weekInTimestamp." GROUP BY Cote HAVING isBilled=0 ORDER BY Cote ASC ";
        $sqlClass->select($Req);
        $installationCotes = array();
        while($installation_results_set = $sqlClass->FetchArray()){
            $installationCotes[] = $installation_results_set['Cote'];
        }

        return $installationCotes;
    }

    public function getInstallations($company, $datetime = null)
    {
        // TODO: Implement getInstallations() method.
    }

    /**
     * @param $isActive
     * @param $inSession
     * @return string
     */
    public function buildSelectInstallationQuery($isActive, $inSession)
    {
        $where = $this->buildWhereClauseFromActiveAndSession($isActive, $inSession);
        if($where==""){
            $where = "1";
        }
        $InstallationReq = "SELECT IDInstallation, Nom FROM `installation` WHERE " . $where. " ORDER BY installation.Nom ASC";

        return $InstallationReq;
    }

    private function buildWhereClauseFromActiveAndSession($isActive, $inSession)
    {
        $isActive = boolval($isActive);
        $inSession = boolval($inSession);

        $where = "";
        if($isActive or $inSession)
        {
            if($isActive and $inSession)
            {
                $where = "Saison AND Actif";
            }elseif($inSession){
                $where = "Saison";
            }else{
                $where = "Actif";
            }
        }

        return $where;
    }

    private function buildInstallationListFromQuery($query){
        $sqlClass =  new $this->connectorClass();
        $sqlClass->Select($query);
        $installation_list = [];

        while($cursor = $sqlClass->FetchAssoc()){
            $installation_list[$cursor['IDInstallation']] = $cursor['Nom'] ;
        }

        return $installation_list;
    }


}
