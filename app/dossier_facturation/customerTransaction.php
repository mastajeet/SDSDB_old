<?php

interface CustomerTransaction{
    function get_customer_transaction();
}

function transaction_comparator($transaction1, $transaction2){
    return $transaction1['date'] > $transaction2['date'];
}