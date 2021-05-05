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
}

