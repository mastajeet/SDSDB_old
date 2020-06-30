<?php
include_once('app/invoice/invoice.php');
include_once('app/invoice/invoice_item/InvoiceItem.php');

class TimedInvoiceItem extends InvoiceItem
{

    private $semaine = null;

    function update_using_next_shift($next_shift){
        $this->End = $next_shift->End;
        $this->Notes = substr($this->Notes,0,-1);
        $employe = new Employee($next_shift->IDEmploye);
        $this->Notes.= "-".$employe->initials().")";
    }

    function update_using_customer_ferie($customer_ferie){
        $associated_facture = new Invoice($this->IDFacture);
        if(is_ferie($this->Jour*86400+$associated_facture->Semaine)){
            if($customer_ferie<>1){
                $this->TXH *= $customer_ferie;
                $this->Notes .= " (x".$customer_ferie. HOLIDAY.")";
            }
        }
    }

    function update_for_minimum_4h(){
        if($this->Start==0 and $this->End==14400){
            $this->Notes .= " (Minimum 4h)";
        }
    }

    function add_to_balance(&$Balance){
        $Balance += $this->getBilledAmount();
    }

    static function findItemByInvoiceId($invoice_id)
    {
        $invoice = new Invoice($invoice_id);
        $invoice_items = array();
        $sql = new SqlClass();
        $database_information = self::define_table_info();
        $query = self::get_item_by_invoice_id_query($invoice_id);  // TODO: Implement find_item_by_facture_id() method.
        $sql->Select($query);
        while($invoice_item_cursor = $sql->FetchArray()){
            $invoice_item = new self($invoice_item_cursor[$database_information['model_table_id']]);
            $invoice_item->semaine = $invoice->Semaine;
            $invoice_items[] = $invoice_item;
        }

        return $invoice_items;
    }

    function getNumberOfBilledItems()
    {
        return( round(($this->End-$this->Start)/NB_SECONDS_PER_HOUR,2));
    }

    function getDetails()
    {
        $invoice_item_datetime = null;
        if(!is_null($this->semaine)){
            $invoice_item_datetime = new DateTime("@".$this->semaine);
            $invoice_item_datetime->add(new DateInterval("P".$this->Jour."D"));
        }
        return array(
            'invoice_id'=>$this->IDFacture,
            'invoice_item_id'=>$this->IDFactsheet,
            "start" =>round(($this->Start)/NB_SECONDS_PER_HOUR,2),
            "end" =>round(($this->End)/NB_SECONDS_PER_HOUR,2),
            "day"=>$this->Jour,
            "item_duration"=>$this->getNumberOfBilledItems(),
            "invoice_item_datetime" => $invoice_item_datetime,
            "notes" => $this->Notes,
            "hourly_rate" =>$this->TXH,
            "total" => $this->getBilledAmount()
        );
    }

    /**
     * @return false|float
     */
    private function getBilledAmount()
    {
        return round(($this->End - $this->Start) / NB_SECONDS_PER_HOUR * $this->TXH, 2);
    }

    static function fromDetails($invoice_item_dto)
    {
        $day = getOrDefault($invoice_item_dto["day"],0);
        $start = getOrDefault($invoice_item_dto["start"],null);
        $end = getOrDefault($invoice_item_dto["end"],0);
        $hourly_rate = getOrDefault($invoice_item_dto["hourly_rate"],0);
        $notes = getOrDefault($invoice_item_dto["notes"],0);
        $invoice_id = getOrDefault($invoice_item_dto["invoice_id"],0);
        $invoice_item_id = getOrDefault($invoice_item_dto["invoice_item_id"],null);

        $base_model_args = array(
            "Start"=>$start*NB_SECONDS_PER_HOUR,
            "End"=>$end*NB_SECONDS_PER_HOUR ,
            "TXH"=>$hourly_rate,
            "Notes"=>$notes,
            "Jour"=>$day,
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
