<?php


namespace SDSApi;


interface resourceFormatter
{
    public function formatRecordSet($recordSet);
    public function formatRecord($record);
}
