<?php
/**
 * Created by PhpStorm.
 * User: mastajeet
 * Date: 15-06-18
 * Time: 22:22
 */

$Req = "DELETE FROM vacances WHERE IDVacances = ".$_GET['IDVacances'];
$SQL = new sqlclass();
$SQL->Delete_data($Req);