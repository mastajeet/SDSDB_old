<?php
namespace installation;


class InstallationService
{
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

    public function getInstallatonListInStringToBillByCote($weekInTimestamp){
        $installationToBillCotes = $this->dataSource->getInstallationCotesToBill($this->companyId, $weekInTimestamp);
        $installationListInStringToBillByCotes = array();
        foreach($installationToBillCotes as $cote)
        {
            $installationListInStringToBillByCotes[$cote] = $this->getInstallationListInStringByCote($cote,1,1);
        }

        return $installationListInStringToBillByCotes;
    }

}

