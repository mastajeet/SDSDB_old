<?php
include_once('app/invoice/invoice_item/InvoiceItem.php');

class CountableCreditedInvoiceItem extends InvoiceItem
{
    function add_to_balance(&$Balance){
        $Balance += $this->getBilledAmount();
    }

    static function findItemByInvoiceId($invoice_id)
    {
        $invoice_items = array();
        $sql = new SqlClass();
        $database_information = self::define_table_info();
        $query = self::get_item_by_invoice_id_query($invoice_id);  // TODO: Implement find_item_by_facture_id() method.
        $sql->Select($query);
        while($invoice_item_cursor = $sql->FetchArray()){
            $invoice_items[] = new self($invoice_item_cursor[$database_information['model_table_id']]);
        }

        return $invoice_items;
    }

    function getNumberOfBilledItems()
    {
        return round(($this->End - $this->Start) / NB_SECONDS_PER_HOUR,2); #This is to support the whole legacy in the database
    }

    function getDetails()
    {
        return array(
            "invoice_item_id"=>$this->IDFactsheet,
            'invoice_id'=>$this->IDFacture,
            "quantity"=>$this->getNumberOfBilledItems(),
            "description" => $this->Notes,
            "unit_cost" => -$this->TXH,
            "total" => $this->getBilledAmount()
        );
    }

    private function getBilledAmount()
    {
        return round($this->getNumberOfBilledItems()*$this->TXH,2);
    }

    static function fromDetails($invoice_item_dto)
    {
        $quantity = getOrDefault($invoice_item_dto["quantity"],0);
        $unit_cost = getOrDefault($invoice_item_dto["unit_cost"],0);
        $description = getOrDefault($invoice_item_dto["description"],0);
        $invoice_id = getOrDefault($invoice_item_dto["invoice_id"],0);
        $invoice_item_id = getOrDefault($invoice_item_dto["invoice_item_id"],null);

        $base_model_args = array(
            "Start"=>0,
            "End"=>$quantity * NB_SECONDS_PER_HOUR,
            "TXH"=>-$unit_cost,
            "Notes"=>$description,
            "Jour"=>0,
            "IDFacture"=>$invoice_id,
            "IDFactsheet"=>$invoice_item_id
        );

       return new self($base_model_args);
    }

    function isEmpty()
    {
        return $this->getBilledAmount()==0;
    }
}
