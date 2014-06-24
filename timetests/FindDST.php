<?php

$NOW = mktime(0, 0, 0, 11, 8, 2011);
$i = 0;
while($i<= 100){
    echo date("c", $NOW-$i*60*60)."<br>";
    $i++;
}

//$NOW-$i*60*60*24
?>
