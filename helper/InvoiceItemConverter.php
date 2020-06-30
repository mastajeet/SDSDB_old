<?php


class InvoiceItemConverter
{
    static function fromRequestDataToDTO($request_data)
    {
        $invoice_id = $request_data['invoice_id'];
        $invoice = InvoiceFactory::getTypedInvoice(new Invoice($invoice_id));

        if($invoice instanceof EquipmentInvoice)
        {
            $invoice_item_dto = self::getEquipmentInvoiceDTOFromRequestData($request_data);
        } else if ($invoice instanceof ShiftInvoice) {
            $invoice_item_dto = self::getShiftInvoiceDTOFromRequestData($request_data);
        } else if ($invoice instanceof Credit) {
            $invoice_item_dto = self::getCreditDTOFromRequestData($request_data);
        }

        return $invoice_item_dto;
    }

    static private function getCountableItemValuesFromRequest($request_data)
    {
        $item_id = getOrDefault($request_data["item_id"],null);
        $unit_cost = 0;

        if(!empty($item_id))
        {
            list($description, $unit_cost) = self::getInvoiceItemValuesFromItemId($item_id);
        }
        if(!empty($request_data["description"]))
        {
            $description = $request_data["description"];
        }
        if(!empty($request_data["unit_cost"]))
        {
            $unit_cost = $request_data["unit_cost"];
        }

        return array(0 => $description, 1 => $unit_cost);
    }

    static private function getInvoiceItemValuesFromItemId($item_id)
    {
        $item = new Item($item_id);
        return array(0 => $item->Description, 1 => $item->Prix1);
    }

    /**
     * @param $request_data
     * @param $invoice_id
     * @return array
     */
    private static function getEquipmentInvoiceDTOFromRequestData($request_data)
    {
        $quantity = $request_data["quantity"];
        $invoice_id = $request_data['invoice_id'];
        list($description, $unit_cost) = self::getCountableItemValuesFromRequest($request_data);

        $invoice_item_dto = array(
            "description" => $description,
            "unit_cost" => $unit_cost,
            "quantity" => $quantity,
            "invoice_id" => $invoice_id
        );

        if (isset($request_data["id_to_update"])) {
            $invoice_item_dto["invoice_item_id"] = $request_data["id_to_update"];
        }
        return $invoice_item_dto;
    }

    private static function getCreditDTOFromRequestData($request_data)
    {
        $quantity = $request_data["quantity"];
        $invoice_id = $request_data['invoice_id'];
        $description = $request_data['description'];
        $unit_cost =  $request_data['unit_cost'];

        $invoice_item_dto = array(
            "description" => $description,
            "unit_cost" => $unit_cost,
            "quantity" => $quantity,
            "invoice_id" => $invoice_id
        );

        if (isset($request_data["id_to_update"])) {
            $invoice_item_dto["invoice_item_id"] = $request_data["id_to_update"];
        }
        return $invoice_item_dto;
    }

    private static function getShiftInvoiceDTOFromRequestData($request_data)
    {
        $invoice_id = $request_data["invoice_id"];
        $day = $request_data["day"];
        $start= $request_data["start"];
        $end = $request_data["end"];
        $notes =  $request_data["notes"];
        $hourly_rate =  $request_data["hourly_rate"];

        $invoice_item_dto = array(
            "day" => $day,
            "start" => $start,
            "end" => $end,
            "notes" => $notes,
            "hourly_rate"=>$hourly_rate,
            "invoice_id" => $invoice_id
        );
        if (isset($request_data["id_to_update"])) {
            $invoice_item_dto["invoice_item_id"] = $request_data["id_to_update"];
        }
        return $invoice_item_dto;
    }
}