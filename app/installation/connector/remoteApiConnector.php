<?php

namespace installation;
use installation\InstallationDataSourceInterface;

class RemoteApiConnector implements InstallationDataSourceInterface{

    public function getInstallationSelectList($company, $isActive, $inSession)
    {
        // TODO: Implement getInstallationSelectList() method.
    }

    public function getInstallationListByCote($company, $cote, $isActive, $inSession)
    {
        // TODO: Implement getInstallationListByCote() method.
    }

    public function getActiveInstallationsCotes()
    {
        // TODO: Implement getActiveInstallationsCotes() method.
    }

    public function getInstallations($company)
    {
        // TODO: Implement getInstallations() method.
    }

    public function getInstallationCotesToBill($company, $weekInTimestamp)
    {
        // TODO: Implement getInstallationCotesToBill() method.
    }
}


