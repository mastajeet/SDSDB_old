<?php
include_once('app/invoice/invoice_item/InvoiceItem.php');

class TimedInvoiceItem extends InvoiceItem
{
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

    function add_bill_item_to_balance(&$Balance){
        $Balance += round(($this->End - $this->Start)/NB_SECONDS_PER_HOUR*$this->TXH,2);
    }


    static function find_item_by_invoice_id($facture_id)
    {
        $invoice_items = array();
        $sql = new SqlClass();
        $database_information = self::define_table_info();
        $query = self::get_item_by_facture_id_query($facture_id);  // TODO: Implement find_item_by_facture_id() method.
        $sql->Select($query);
        while($invoice_item_cursor = $sql->FetchArray()){
            $invoice_items[] = new TimedInvoiceItem($invoice_item_cursor[$database_information['model_table_id']]);
        }

        return $invoice_items;
    }
}
