<?php

class HTMLInvoiceRenderer extends HTMLContainerRenderer
{
    private $invoice_type;
    private $invoice_item_type;
    private $company;
    private $printable;
    private $available_options;

    function __construct($invoice_type, $invoice_item_typeRenderer, $company, $printable)
    {
        $this->company = $company;
        $this->invoice_type = $invoice_type;
        $this->invoice_item_type = $invoice_item_typeRenderer;
        $this->printable = $printable;
        $this->buildAvailableOptionList();
        $this->verifyOptions();
        $this->getRenderers();
    }

    function buildContent($content_array)
    {

    }

    private function buildAvailableOptionList()
    {
        $this->buildCompanyOptions();
        $this->buildInvoiceTypeOptions();
        $this->buildInvoiceItemTypeOptions();
        $this->buildPrintableOptions();
    }

    private function verifyOptions()
    {
        assertContains($this->company, $this->available_options['company']);
        assertContains($this->invoice_type, $this->available_options['invoice_type']);
        assertContains($this->invoice_item_type, $this->available_options['invoice_item_type']);
        assertContains($this->printable, $this->available_options['printable']);
    }

    private function getRenderers()
    {

    }

    private function getHeaderRenderer($invoice_type, $printable)
    {

    }

    private function getCoteRenderer($company)
    {

    }

    private function getFooterRenderer($company)
    {

    }

    private function getInvoiceItemRenderer($invoice_item_type)
    {

    }

    private function getInvoiceControlRenderer($printable)
    {

    }

    private function buildCompanyOptions()
    {
        $this->available_options['company'] = array();
        $this->available_options['company'][] = "qc";
        $this->available_options['company'][] = "mtl";
        $this->available_options['company'][] = "tr";
    }

    private function buildInvoiceTypeOptions()
    {
        $this->available_options['invoice_type'] = array();
        $this->available_options['invoice_type'][] = "ShiftInvoice";
        $this->available_options['invoice_type'][] = "EquipmentInvoice";
        $this->available_options['invoice_type'][] = "InterestInvoice";
        $this->available_options['invoice_type'][] = "AvanceClient";
        $this->available_options['invoice_type'][] = "Credit";
    }

    private function buildInvoiceItemTypeOptions()
    {
        $this->available_options['invoice_item_type'] = array();
        $this->available_options['invoice_item_type'][] = "TimedInvoiceItem";
        $this->available_options['invoice_item_type'][] = "CountableInvoiceItem";
    }

    private function buildPrintableOptions()
    {
        $this->available_options['printable'] = array();
        $this->available_options['printable'][] = true;
        $this->available_options['printable'][] = false;
    }
}
