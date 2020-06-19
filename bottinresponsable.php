<?PHP

$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('10');
	$MainOutput->AddTexte('&nbsp;','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('150');
	$MainOutput->AddTexte('Nom','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('150');
	$MainOutput->AddTexte('Pr�nom','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('150');
	$MainOutput->AddTexte('Tel�phone','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('300');
	$MainOutput->AddTexte('Client / Piscine','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$SQL = new SQLClass();
$Req = "
(SELECT DISTINCT IDResponsable AS ID, responsable.Nom AS RNom, Prenom AS RPrenom, responsable.Tel as Telephone, client.Nom AS CNom, client.IDClient as CID
FROM responsable
RIGHT JOIN client ON client.RespP = IDResponsable
OR client.RespF = IDResponsable
)
UNION (
SELECT DISTINCT responsable.IDResponsable AS ID, responsable.Nom AS RNom, Prenom AS RPrenom, responsable.Tel as Telephone, concat( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Installation: ', installation.Nom ) AS CNom, 
installation.IDClient as CID
FROM responsable
RIGHT JOIN installation ON installation.IDResponsable = responsable.IDResponsable
)
ORDER BY CID ASC, CNom DESC, RNom ASC, RPrenom ASC";
$SQL->SELECT($Req);


$c="two";
$CID = 0;
while($v = $SQL->FetchArray()){

if($v[1]=="" AND $v[2]=="")
	True;
else{


	$class="Texte";
	$c="one";
	if($CID<>$v[5]){
	$c="two";
		$class="Titre";
		$CID=$v[5];
		$CNOM=$v[4];
	}else{
		if($CNOM==$v[4])
		
			$class="Titre";
	}

	$MainOutput->OpenRow('',$c);
	$MainOutput->OpenCol('10');
		$MainOutput->addlink('index.php?Section=Responsable_Form&IDResponsable='.$v[0], '<img src=assets/buttons/b_edit.png border=0>');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('150');
		$MainOutput->AddTexte($v[1]);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('150');
		$MainOutput->AddTexte($v[2]);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('150');
		$MainOutput->addphone($v[3]);
	$MainOutput->CloseCol();
	

	$MainOutput->OpenCol('300');
		$MainOutput->AddTexte($v[4],$class);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
}

}

$MainOutput->CloseTable();
echo $MainOutput->Send(1);

?>