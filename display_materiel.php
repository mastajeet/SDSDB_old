<?PHP
$SQL = new sqlclass();
$Req = "SELECT * FROM item WHERE Actif ORDER BY IDItem ASC";
$SQL->Select($Req);

$MainOutput->OpenTable('620');


$MainOutput->OpenRow();
	$MainOutput->OpenCol('',7);
		$MainOutput->AddTexte('Liste de matériel','Titre');
		$MainOutput->addlink('index.php?Section=Materiel_Form','<img border=0 src=b_ins.png>');
	$MainOutput->CloseCol();
$MainOutput->CloseRow();


	$MainOutput->OpenRow();
	
	$MainOutput->OpenCol('10');
		$MainOutput->AddTexte('&nbsp;','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('10');
		$MainOutput->AddTexte('ID','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('250');
		$MainOutput->AddTexte('Nom','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('100');
		$MainOutput->AddTexte('Fournisseur','Titre');
	$MainOutput->CloseCol();

	$MainOutput->OpenCol('80');
		$MainOutput->AddTexte('Prix&nbsp;unitaire','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('80');
		$MainOutput->AddTexte('NB&nbsp;Forfait','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('80');
		$MainOutput->AddTexte('Prix&nbsp;forfait','Titre');
	$MainOutput->CloseCol();




	$MainOutput->CloseRow();

$c="four";





	while($Rep = $SQL->FetchArray()){
if($c=="four")
	$c="three";
else
	$c="four";



	
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('10');
		$MainOutput->addlink('index.php?Section=Materiel_Form&IDItem='.$Rep['IDItem'],'<img border=0 src=b_edit.png>');
		
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('10',1,'baseline',$c);
		$MainOutput->AddTexte($Rep['IDItem']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('250',1,'baseline',$c);
		$MainOutput->AddTexte($Rep['Description']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('100',1,'baseline',$c);
		$MainOutput->AddTexte($Rep['Fournisseur']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('80',1,'baseline',$c);
		$MainOutput->AddTexte(number_format($Rep['Prix1'],2)." $");
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('80',1,'baseline',$c);
		$MainOutput->AddTexte("&nbsp;".$Rep['NBForfait']);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('80',1,'baseline',$c);
		$MainOutput->AddTexte(number_format($Rep['PrixForfait'],2)." $");
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	}
$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>
