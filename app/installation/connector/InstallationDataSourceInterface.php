<?php

namespace installation;

interface InstallationDataSourceInterface
{
    public function getInstallationSelectList($company, $isActive, $inSession);
    public function getInstallationListByCote($company, $cote, $isActive, $inSession);
    public function getActiveInstallationsCotes();
    public function getInstallations($company);
    public function getInstallationCotesToBill($company, $weekInTimestamp);
}
