<?php

function extractViolationFromResponse(array &$violationList, $apiEndPoint, $problematicID, array $responseDTO)
{
    if (array_key_exists('violations', $responseDTO)) {
        foreach($responseDTO['violations'] as $k=>$values)
        {
            $violationList[] = $problematicID.";".$apiEndPoint.";".$values['propertyPath'].";".$values['message'];
        }
    }
}