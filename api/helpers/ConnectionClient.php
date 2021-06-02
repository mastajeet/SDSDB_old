<?php


namespace SDSApi;




class ConnectionClient{

    public $client;

    function __construct($apiConnectionBaseInfo){
        $this->client = $this->getClient($apiConnectionBaseInfo);
    }

    private function getClient($apiConnectionBaseInfo){
        if($apiConnectionBaseInfo->companyId == 1){
            $filename = "../mysql_class_qc.php";
        }elseif ($apiConnectionBaseInfo->companyId == 2){
            $filename = "../mysql_class_mtl.php";
        }elseif($apiConnectionBaseInfo->companyId == 3){
            $filename = "../mysql_class_tr.php";
        }

        include_once($filename);

        return new \SqlClass();
    }

    function get($resourceRequest){
        $this->client->Select($resourceRequest);
        $returnDataset = array();

        while($cursor = $this->client->FetchAssoc()){
            $returnDataset[] = $cursor;
        }

        return $returnDataset;
    }
}
