<?PHP
$MainOutput->AddTexte("<u>"."Messages à tous"."</u>",'Titre');
$MainOutput->br();
$MSG = get_messages();
$Month = get_month_list('long');
foreach($MSG as $v){

	$Inf = get_employe_info($v['IDEmploye']);
	$Date = get_date($v['Start']);
	$MainOutput->AddTexte($v['Titre'],'Titre');
	$MainOutput->AddTexte(" posté le ".$Date['d']." ".$Month[intval($Date['m'])]." ".$Date['Y']);
	$MainOutput->br();
	$MainOutput->AddTexte($v['Texte'].'<br>- '.$Inf['Prenom']);
	$MainOutput->br(2);
}
$MainOutput->AddTexte("<u>"."Pour les Piscines"."</u>",'Titre');
$MainOutput->br();
$SQL2 = new sqlclass();
$Req = "SELECT sum(Cadenas) as A, sum(Punch) as B FROM shift JOIN installation on shift.IDInstallation = installation.IDInstallation WHERE IDEmploye = ".$_COOKIE['IDEmploye'];
$SQL2->SELECT($Req);
$Rep = $SQL2->FetchArray();
$Inst = "";
if($Rep['B']<>0)
	$Inst .= "<li>n'oubliez pas de puncher <b>au commencement</b> du shift -soit à 7h, 8h ou 9h - 
	et <b>à la fin</b> - soit vers 20h, 22h ou 23h.";

if($Inst<>""){
	$MainOutput->Addtexte("	<ul>".$Inst."</ul>");
}

$Req = "SELECT Distinct Nom, Notes, Toilettes FROM shift JOIN installation ON shift.IDInstallation = installation.IDInstallation WHERE IDEmploye = ".$_COOKIE['IDEmploye']." AND Semaine>=".get_last_sunday();
$SQL2->SELECT($Req);
$MainOutput->AddTexte("Plus spécifiquement :
<ul>");
while($Rep = $SQL2->FetchArray()){
	if($Rep['Toilettes']<>"")
		$MainOutput->AddTexte('<li><b>'.$Rep['Nom'].' - Toilettes</b>: '.$Rep['Toilettes']);
	if($Rep['Notes']<>"")
		$MainOutput->AddTexte('<li><b>'.$Rep['Nom'].' - Notes</b>: '.$Rep['Notes']);
}
$MainOutput->AddTexte("</ul>");

echo $MainOutput->Send(1);