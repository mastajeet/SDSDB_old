<?php


class EquipmentInvoiceItemFormFieldsRenderer extends HTMLContainerRenderer
{
    private $equipment_array;

    function __construct($equipment_array)
    {
        $this->equipment_array = $equipment_array;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $invoice_id = $content_array["invoice_id"];
        $this->html_container->inputhidden_env('invoice_id',$invoice_id);

        $this->html_container->openrow();
        $this->html_container->opencol('100%',2);
        $this->html_container->addtexte("---- Ajout automatique ----",'titre');
        $this->html_container->closecol();
        $this->html_container->closerow();

        $this->html_container->InputSelect('item_id',$this->equipment_array,-1,'Item');

        $this->html_container->openrow();
        $this->html_container->opencol('100%',2);
        $this->html_container->addtexte("---- Ou Ajout manuel (valeurs prioritaires) ----",'titre');
        $this->html_container->closecol();
        $this->html_container->closerow();

        $this->html_container->InputText('description','Item','40',null);
        $this->html_container->InputText('unit_cost','Prix unitaire',5,null);

        $this->html_container->openrow();
        $this->html_container->opencol('100%',2);
        $this->html_container->addtexte("----------",'titre');
        $this->html_container->closecol();
        $this->html_container->closerow();

        $this->html_container->InputText('quantity','Quantité','1',1);
    }
}
