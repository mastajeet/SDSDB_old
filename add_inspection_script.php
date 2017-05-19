<?PHP
$ItemList = Array(	'EchellePP','EchelleX2P','Couverture','Chlore','Escalier','Cloture12','Cloture100','Maille38','Promenade','Fermeacle','ProfondeurPP','ProfondeurP','ProfondeurPente','Cercle','Verre','Bousculade','Maximum','Mirador','SMU','Procedures','Perche','Bouees','Planche','Registre',
					'LigneBouee','Bouees','NotesBouees','Chaloupe','ChaloupeRame','ChaloupeAncre','ChaloupeGilets','ChaloupeBouee','HeureSurveillance','LimitePlage',
					'Manuel','Antiseptique','Epingle','Pansement','BTria','Gaze50','Gaze100','Ouate','Gaze75','Compressif','Tape12','Tape50','Eclisses','Ciseau','Pince','Crayon','Masque','Gant');

foreach($ItemList as $k){
	if(!isset($_POST['FORM'.$k]) OR $_POST['FORM'.$k]=="" OR $_POST['FORM'.$k]== " ")
		$_POST['FORM'.$k]=0;
}

$new_inspection_values = array();
$new_inspection_values['Annee'] = get_vars('BoniYear');
foreach($_POST as $k=>$v){
	if(substr($k,0,4)=="FORM"){
		if(substr($k,0,9)=='FORMDateI'){
			$new_inspection_values['DateI']=mktime(0,0,0,$_POST['FORMDateI4'],$_POST['FORMDateI5'],$_POST['FORMDateI3']);
		}else{
			$new_inspection_values[substr($k,4)] = $v;
			}
	}else{
		if($k=="IDInstallation"){
			$new_inspection_values[$k] = $v;
		}
		if($k=="IDInspection"){
			$new_inspection_values[$k] = $v;
		}
	}
}


$inspection = new inspection($new_inspection_values);
$inspection->save();

$_GET['Section']="Inspection";
?>
