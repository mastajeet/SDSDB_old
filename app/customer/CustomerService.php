<?php
namespace customer;
use Customer;

class CustomerService
{
    function __construct($companyId, CustomerDataSourceInterface $dataSource)
    {
        $this->companyId =$companyId;
        $this->dataSource = $dataSource;
    }

}
