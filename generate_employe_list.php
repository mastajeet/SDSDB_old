<?PHP
//No, Nom, Prenom, Tel, Cell, Secteur, Qualif-Age
$Month = get_month_list("court");

if($_GET['ToPrint'])
	$NBCol = 7;
else
	$NBCol = 10;


if(!isset($_GET['Cessation']))
	$_GET['Cessation']=0;

if(!isset($_GET['Session']))
	$_GET['Session']=get_vars('Saison');

if(!isset($_GET['Field'])){
	$_GET['Field']="employe.Nom";
}

if(!isset($_GET['Order'])){
	$_GET['Order']="ASC";
}

if($_GET['Order']=="ASC")
	$Unorder = "DESC";
else
	$Unorder = "ASC";
if(!isset($_GET['Assistant']))
	$_GET['Assistant']=0;
$CondAssistant = "AND `EAssistant` = 0";
if(isset($_GET['Assistant']) and $_GET['Assistant']=="1")
$CondAssistant = "AND `EAssistant` = 1";
if(isset($_GET['Assistant']) AND $_GET['Assistant']=="%")
$CondAssistant = "";

$MainOutput->OpenTable('800');
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',$NBCol);

$MainOutput->Addlink('index.php?Section=EmployeList&Assistant=1&Session=%','Assistants');
$MainOutput->Addtexte(' - ');
	
	$List = get_saison_list();
Foreach($List as $v){
	$MainOutput->Addlink('index.php?Section=EmployeList&Session='.$v.'&Assistant=0',$v);
	$MainOutput->Addtexte(' ( ');
	$MainOutput->Addlink('index.php?Section=EmployeEmailList&Session='.$v.'&Assistant=0&ToPrint=TRUE&Email=TRUE&Target=_BLANK',"Email");
	$MainOutput->Addtexte(' ) - ');
}


$MainOutput->Addlink('index.php?Section=EmployeList&Session=&Assistant=%','Pas rejoinds');
$MainOutput->Addtexte(' - ');
$MainOutput->Addlink('index.php?Section=EmployeList&Session=%&Assistant=%','Tous');
$MainOutput->Addtexte(' - ');
$MainOutput->Addlink('index.php?Section=EmployeList&Cessation=1','Cessationnés');


$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow();

$MainOutput->OpenCol(10);
$MainOutput->addtexte('&nbsp;');
$MainOutput->CloseCol();

$MainOutput->OpenCol(20);
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=IDEmploye&Order='.$Unorder.'&Cessation='.$_GET['Cessation'].'&Assistant='.$_GET['Assistant'],'No');
$MainOutput->CloseCol();

$MainOutput->OpenCol(100);
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=employe.Nom&Order='.$Unorder.'&Cessation='.$_GET['Cessation'].'&Assistant='.$_GET['Assistant'],'Nom');
$MainOutput->CloseCol();

$MainOutput->OpenCol(100);
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=Prenom&Order='.$Unorder.'&Cessation='.$_GET['Cessation'].'&Assistant='.$_GET['Assistant'],'Prénom');
$MainOutput->CloseCol();

$MainOutput->OpenCol(100);
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=TelP&Order='.$Unorder.'&Cessation='.$_GET['Cessation'].'&Assistant='.$_GET['Assistant'],'Telephone');
$MainOutput->CloseCol();

$MainOutput->OpenCol(100);
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=Cell&Order='.$Unorder.'&Cessation='.$_GET['Cessation'].'&Assistant='.$_GET['Assistant'],'Cellulaire');
$MainOutput->CloseCol();

if(!$_GET['ToPrint']){
	$MainOutput->OpenCol(100);
	$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=secteur.Nom&Order='.$Unorder.'&Cessation='.$_GET['Cessation'].'&Assistant='.$_GET['Assistant'],'Secteur');
	$MainOutput->CloseCol();
	
	$MainOutput->OpenCol(100);
	$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=`Status`&Order='.$Unorder.'&Cessation='.$_GET['Cessation'].'&Assistant='.$_GET['Assistant'],'Status');
	$MainOutput->CloseCol();
}
	$MainOutput->OpenCol(100);
	$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=`DateNaissance`&Order='.$Unorder.'&Cessation='.$_GET['Cessation'].'&Assistant='.$_GET['Assistant'],'Qualification');
	$MainOutput->CloseCol();
	
	
	if(!$_GET['ToPrint']){
	$MainOutput->OpenCol();
	$MainOutput->addTexte('Dernier&nbsp;AccÃ©s');
	$MainOutput->CloseCol();
}

$MainOutput->CloseRow();
 
$SQL = new sqlclass;
$SQL2 = new sqlclass;

if($_GET['Cessation']==1){
$Req = "SELECT IDEmploye, employe.`Nom` , Prenom, TelP, Cell, secteur.Nom, `Status`, DateNaissance, Session, EAssistant
FROM employe
LEFT JOIN secteur ON employe.IDSecteur = secteur.IDSecteur
WHERE `Cessation` ORDER BY ".$_GET['Field']." ".$_GET['Order'];	
}ELSE{
$Req = "SELECT IDEmploye, employe.`Nom` , Prenom, TelP, Cell, secteur.Nom, `Status`, DateNaissance, Session, EAssistant
FROM employe
LEFT JOIN secteur ON employe.IDSecteur = secteur.IDSecteur
WHERE `Session` LIKE '".$_GET['Session']."' AND !`Cessation` ".$CondAssistant." ORDER BY ".$_GET['Field']." ".$_GET['Order'];
}
$SQL->SELECT($Req);
$c="two";

while($v = $SQL->FetchArray()){
$LV = get_lastvisited($v['IDEmploye']);


if($c=="two")
	$c="one";
else
	$c="two";
$MainOutput->OpenRow('',$c);
		
		$MainOutput->OpenCol('10');
		$MainOutput->addlink('index.php?Section=Employe&IDEmploye='.$v[0],'<img src=b_edit.png border=0>');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('20');
		$MainOutput->addtexte($v[0]);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte(substr($v[1],0,12));
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte(substr($v[2],0,15));
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
if(!$_GET['ToPrint']){
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte(substr($v[5],0,15));
		$MainOutput->CloseCol();
	if(!$v['EAssistant']){
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v[6]);
		$MainOutput->CloseCol();
	}else{
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v['Session']);
		$MainOutput->CloseCol();
	}
		}

	$Req2 = "SELECT Qualification, Expiration FROM link_employe_qualification JOIN qualification ON qualification.IDQualification = link_employe_qualification.IDQualification WHERE IDEmploye = ".$v[0]." ORDER BY link_employe_qualification.IDQualification ASC";
	$SQL2->SELECT($Req2);
	$Qualif="<span class=Titre>".get_age($v[7])."</span>";
	$New = TRUE;
	While($Rep = $SQL2->FetchArray()){
		$Class='Texte';
		if(intval(date('n',time())) > intval(date('n',$Rep['Expiration'])) AND intval(date('Y',time()))>=intval(date('Y',$Rep['Expiration'])))
			$Class='Warning';
		
		if($New){
			$Qualif .= "<span class=".$Class.">: ".$Rep[0]."</span>";			
			$New=FALSE;
		}else{
			$Qualif = $Qualif."<span class=Texte> - </span><span class=".$Class.">".$Rep[0]."</span>";
		}
	}
		
	$MainOutput->OpenCol('100');	
	$MainOutput->addoutput($Qualif,0,0);
	$MainOutput->CloseCol();		

	if(!$_GET['ToPrint']){
		if($LV[0]<>0){
			$MainOutput->OpenCol('100');
			$MainOutput->addtexte($LV['mday']." ".$Month[$LV['mon']]." ".$LV['year']);
			$MainOutput->CloseCol();
		}else{
			$MainOutput->OpenCol('100');
			$MainOutput->addtexte('Jamais');
			$MainOutput->CloseCol();
		}
	}
		
$MainOutput->CloseRow();
}
$MainOutput->CloseTable();
echo $MainOutput->Send(1);





?>