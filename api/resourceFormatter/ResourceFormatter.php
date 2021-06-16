<?php


namespace SDSApi;


interface ResourceFormatter
{
    public function formatRecordSet($recordSet);
    public function formatRecord($record);
}
