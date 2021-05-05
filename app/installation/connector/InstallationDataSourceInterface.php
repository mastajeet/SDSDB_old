<?php

namespace installation;

interface InstallationDataSourceInterface
{
    public function getInstallationSelectList($company, $isActive, $inSession);
    public function getInstallations($company, $datetime=null);
}
