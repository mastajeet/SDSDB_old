<?PHP
$Req = "SELECT * FROM vars WHERE 1";
$SQL = new sqlclass;
$SQL->select($Req);
while($Rep = $SQL->FetchArray()){
	$MainOutput->AddForm('Modifier la variable d\'environnement : '.$Rep['Nom']);
	$MainOutput->InputHidden_Env('Action','ModifieVars');
	$MainOutput->InputHidden_Env('Vars',$Rep['Nom']);
	$MainOutput->inputtext('Value',$Rep['Nom'],28,$Rep['Valeur']);
	$MainOutput->FormSubmit('Modifier');
}
echo $MainOutput->Send(1);

?>