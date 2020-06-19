<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$MainOutput = new HTMLContainer();
$MainOutput->addtexte("Il y a trop de personnes connect�es en meme temps. veuillez revenir dans les prochaines minutes");
echo $MainOutput->send(1);
?>
