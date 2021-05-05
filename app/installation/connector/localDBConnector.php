<?php
namespace installation;

use phpDocumentor\Reflection\Types\Boolean;

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
        return $this->buildInstallationList($InstallationReq);
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
        $isActive = boolval($isActive);
        $inSession = boolval($inSession);

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
        } else{
            $where = "1";
        }

        $InstallationReq = "SELECT installation.IDInstallation, installation.Nom FROM `installation` WHERE " . $where. " ORDER BY installation.Nom ASC";
        return $InstallationReq;
    }

    private function buildInstallationList($query){
        $sql_class =  new $this->connectorClass();
        $sql_class->Select($query);
        $installation_list = [];

        while($cursor = $sql_class->FetchAssoc()){
            $installation_list[$cursor['IDInstallation']] = $cursor['Nom'] ;
        }

        return $installation_list;
    }

}
