<?php
namespace installation;


class InstallationService
{
    private $currentSession;
    private $companyId;

    function __construct($companyId, InstallationDataSourceInterface $dataSource)
    {
        $this->companyId =$companyId;
        $this->dataSource = $dataSource;
    }

    public function getInstallationSelectList($isActive, $inSession)
    {
        return $this->dataSource->getInstallationSelectList($this->companyId, $isActive, $inSession);
    }

    public function getInstallationListInStringByCote($cote, $isActive, $inSession)
    {
        $installationList = $this->dataSource->getInstallationListByCote($this->companyId, $cote, $isActive, $inSession);
        $returnString = "";
        foreach($installationList as $id => $nom)
            $returnString = $returnString.", ".stripslashes($nom);

        return substr($returnString,2);
    }

    public function getInstallationsCotes(){
        return $this->dataSource->getActiveInstallationsCotes();
    }
}

