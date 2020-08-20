<?php

function extractViolationFromResponse(array &$violationList, $apiEndPoint, $employeeId, array $responseDTO)
{
    if (array_key_exists('violations', $responseDTO)) {
        foreach($responseDTO['violations'] as $k=>$values)
        {
            $violationList[] = $employeeId.";".$apiEndPoint.";".$values['propertyPath'].";".$values['message'];
        }
    }
}