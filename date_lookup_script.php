<?PHP
$Date = get_Last_sunday(0,mktime(0,0,0,$_POST['FORMDate4'],$_POST['FORMDate5'],$_POST['FORMDate3']));
$_GET['MenuSection'] = "Display_Shift";
$_GET['Section'] = "Display_Shift";
$_GET['Semaine'] = $Date;
?>