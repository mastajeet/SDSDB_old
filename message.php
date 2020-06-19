<?PHP
$MainOutput->OpenTable('550');

$MainOutput->OpenRow();
$MainOutput->OpenCol('',4);
	$MainOutput->AddTexte('Liste des messages','Titre');
	$MainOutput->addlink('index.php?Section=Message_Form', '<img border=0 src=assets/buttons/b_ins.png>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();

$MainOutput->OpenCol('20');
	$MainOutput->AddTexte('&nbsp;');
$MainOutput->CloseCol();

$MainOutput->OpenCol('230');
	$MainOutput->AddTexte('Titre','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('150');
	$MainOutput->AddTexte('Du','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('150');
	$MainOutput->AddTexte('Au','Titre');
$MainOutput->CloseCol();

$Month = get_month_list('long');
$SQL = new sqlclass;
$Req = "SELECT IDMessage, Titre, Start, End FROM message ORDER BY Start DESC, End DESC";
$SQL->SELECT($Req);

while($Rep = $SQL->FetchArray()){

	$MainOutput->OpenRow();
		$MainOutput->OpenCol('20');
		$MainOutput->addlink('index.php?Section=Message_Form&IDMessage='.$Rep['IDMessage'], '<img border=0 src=assets/buttons/b_edit.png>');
		$MainOutput->CloseCol();
		
		$MainOutput->OpenCol();
		$MainOutput->AddTexte($Rep['Titre']);
		$MainOutput->CloseCol();
	
	$Date = get_date($Rep['Start']);
		$MainOutput->OpenCol();
			$MainOutput->addtexte($Date['d']." ".$Month[intval($Date['m'])]." ".$Date['Y']);
		$MainOutput->Closecol();
		
		
	$Date = get_date($Rep['End']);
		$MainOutput->OpenCol();
			$MainOutput->addtexte($Date['d']." ".$Month[intval($Date['m'])]." ".$Date['Y']);
		$MainOutput->Closecol();
}
$MainOutput->CloseTable();
echo $MainOutput->send();
?>