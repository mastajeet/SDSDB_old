<?PHP
if(!isset($_GET['Cessation'])){
	$_GET['Cessation']=0;
}
if(!isset($_GET['Session'])){
	$_GET['Session']="H07";
}
if(!isset($_GET['Field'])){
	$_GET['Field']="employe.Nom";
}
if(!isset($_GET['Len'])){
	$_GET['Len']="Short";
}
if(!isset($_GET['Order'])){
	$_GET['Order']="ASC";
}
if($_GET['Order']=="ASC")
	$Unorder = "DESC";
else
	$Unorder = "ASC";

$MainOutput->opentable('100%');

$MainOutput->openRow();
$MainOutput->openCol('100%',8);

$List = get_saison_list();
Foreach($List as $v){
$MainOutput->Addlink('index.php?Section=EmployeList&Session='.$v,$v);
$MainOutput->Addtexte(' - ');
}


$MainOutput->Addlink('index.php?Section=EmployeList&Session=','Pas rejoinds');
$MainOutput->Addtexte(' - ');
$MainOutput->Addlink('index.php?Section=EmployeList&Cessation=1','Cessationn�s');

$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();

$MainOutput->OpenCol('10');
$MainOutput->addtexte('&nbsp;');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=IDEmploye&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'No');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=employe.Nom&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Nom');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=Prenom&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Pr�nom');
$MainOutput->CloseCol();

	
$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=TelP&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Tel�phone');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=Cell&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Cellulaire');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=secteur.Nom&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Secteur');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=`Status`&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Status');
$MainOutput->CloseCol();

$MainOutput->CloseRow();

$SQL = new sqlclass;

if($_GET['Cessation']==1){
$Req = "SELECT IDEmploye, employe.`Nom` , Prenom, TelP, Cell, secteur.Nom, `Status`
FROM employe
LEFT JOIN secteur ON employe.IDSecteur = secteur.IDSecteur
WHERE `Cessation` ORDER BY ".$_GET['Field']." ".$_GET['Order'];	
}ELSE{
$Req = "SELECT IDEmploye, employe.`Nom` , Prenom, TelP, Cell, secteur.Nom, `Status`
FROM employe
LEFT JOIN secteur ON employe.IDSecteur = secteur.IDSecteur
WHERE `Session`='".$_GET['Session']."' AND !`Cessation` ORDER BY ".$_GET['Field']." ".$_GET['Order'];
}
$SQL->SELECT($Req);
$c="two";
while($v = $SQL->FetchArray()){



if($c=="two")
	$c="one";
else
	$c="two";
$MainOutput->OpenRow('',$c);
		
		$MainOutput->OpenCol('10');
		$MainOutput->addlink('index.php?Section=Employe&IDEmploye='.$v[0], '<img src=assets/buttons/b_edit.png border=0>');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('20');
		$MainOutput->addtexte($v[0]);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v[1]);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v[2]);
		$MainOutput->CloseCol();
		
		if(strlen($v[3])<10)
			$v[3]="";
		else
			$v[3] = "(".substr($v[3],0,3).") ".substr($v[3],3,3)."-".substr($v[3],6,4);
		
		$MainOutput->OpenCol(40);
		$MainOutput->addtexte($v[3]);
		$MainOutput->CloseCol();
		
		if(strlen($v[4])<10)
			$v[4]="";
		else
			$v[4] = "(".substr($v[4],0,3).") ".substr($v[4],3,3)."-".substr($v[4],6,4);
		
		$MainOutput->OpenCol(40);
		$MainOutput->addtexte($v[4]);
		$MainOutput->CloseCol();

		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v[5]);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v[6]);
		$MainOutput->CloseCol();
$MainOutput->CloseRow();
}
$MainOutput->Closetable();
echo $MainOutput->Send(1);
?>