<?php
include_once('view/EmptyHTMLContainerRenderer.php');
include_once('view/invoice/display_invoice/controls/InvoiceControlsRenderer.php');
include_once('view/invoice/display_invoice/TitleRenderer.php');
include_once('view/invoice/display_invoice/details/InvoiceSummaryDetailsRenderer.php');
include_once('view/invoice/display_invoice/details/InvoiceRecipientDetailsRenderer.php');
include_once('view/invoice/display_invoice/CoteRenderer.php');
include_once('view/invoice/display_invoice/billing_period/MonthlyBillingPeriodRenderer.php');
include_once('view/invoice/display_invoice/billing_period/WeeklyBillingPeriodRenderer.php');
include_once('view/invoice/display_invoice/communication_method/EmailAddressRenderer.php');
include_once('view/invoice/display_invoice/communication_method/FaxNumberRenderer.php');
include_once('view/invoice/display_invoice/HeaderRenderer.php');

class HeaderRendererFactory
{
    private $time_service;

    function __construct(TimeService $time_service)
    {
        $this->time_service = $time_service;
    }

    function getHeaderRenderer(Invoice $invoice, Customer $customer, $company,  $edit)
    {
        $invoice_controls_renderer = $this->getInvoiceControlRenderer($edit);
        $invoice_title_renderer = $this->getInvoiceTitleRenderer($invoice);
        $summary_details_renderer = $this->getSummaryDetailsRenderer($invoice, $customer, $company);
        $recipient_details_renderer = $this->getRecipientDetailsRenderer($customer);
        $invoice_width = $this->getInvoiceWidth($invoice);

        return new HeaderRenderer($invoice_title_renderer,  $invoice_controls_renderer, $summary_details_renderer, $recipient_details_renderer, $invoice_width);
    }

    private function getInvoiceControlRenderer($edit)
    {
        if ($edit) {
            $invoice_control_renderer = new InvoiceControlsRenderer();
        } else {
            $invoice_control_renderer = new EmptyHTMLContainerRenderer();
        }

        return $invoice_control_renderer;
    }

    private function getInvoiceTitleRenderer(Invoice $invoice)
    {
        return new TitleRenderer($invoice);
    }

    private function getSummaryDetailsRenderer(Invoice $invoice, $company)
    {
        $cote_renderer = $this->getCoteRenderer($invoice, $company);
        $billing_period_renderer = $this->getBillingPeriodRenderer($invoice);

        return new InvoiceSummaryDetailsRenderer($cote_renderer, $billing_period_renderer);
    }

    private function getRecipientDetailsRenderer(Customer $customer)
    {
        $communication_method_renderer = $this->getCommunicationMethodRenderer($customer);

        return new InvoiceRecipientDetailsRenderer($communication_method_renderer);
    }

    private function getCoteRenderer(Invoice $invoice, $company)
    {
        return new CoteRenderer($invoice, $company);
    }

    private function getBillingPeriodRenderer(Invoice $invoice)
    {
        if($invoice->isMonthly())
        {
            return new MonthlyBillingPeriodRenderer();
        }
        elseif($invoice->isWeekly())
        {
            return new WeeklyBillingPeriodRenderer($this->time_service);
        }else{
            return new EmptyHTMLContainerRenderer();
        }


        throw new UnexpectedValueException();
    }

    private function getCommunicationMethodRenderer(Customer $customer)
    {
        if($customer->Facturation=="E")
        {
            return new EmailAddressRenderer();
        }elseif($customer->Facturation=="F"){
            return new FaxNumberRenderer();
        }

        throw new UnexpectedValueException();
    }

    private function getInvoiceWidth(Invoice $invoice)
    {
        if($invoice instanceof ShiftInvoice)
        {
            return 7;
        }else{
            return 4;
        }
    }
}
