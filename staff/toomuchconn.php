<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$MainOutput = new HTML();
$MainOutput->addtexte("Il y a trop de personnes connectées en meme temps. veuillez revenir dans les prochaines minutes");
echo $MainOutput->send(1);
?>
