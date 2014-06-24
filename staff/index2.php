<?PHP
$WarningOutput = new HTML;
$MainOutput = new HTML;
include('staff/action.php');
include('staff/functions.php');
?>
<HTML>
<title>Gestion Service de Sauveteur</title>
<link rel="STYLESHEET" type="text/css" href="style.css">
<link rel="STYLESHEET" type="text/css" href="horaire.css">
	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="css/images/favicon.ico" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" />
	<![endif]-->
	<script type="text/javascript" src="js/jquery-1.5.min.js"></script>
	<script type="text/javascript" src="js/jquery-func.js"></script>
</head>

<body>
<!-- Shell -->
<div class="shell">
    <!-- Header -->
    <div id="header">
        <h1 id="logo"><a class="notext" href="#">Sauveteurs</a></h1>
        <div class="intro">
            <img src="css/images/intro-image.jpg" alt="image" />
        </div>
        <div class="cl">&nbsp;</div>
        <!-- Navigation -->
        <div id="navigation" align="center">
            <ul>
                <?PHP
                $Active = "class=\"active\"";
                $Accueil="";
                $Info="";
                $Horaire="";
                $Confirm_Heures="";
                $Joindre="";
                
                if(!isset($_GET['Section']) or $_GET['Section']=="Accueil") 
                    $Welcome = $Active;
                else{
                    if($_GET['Section']=="Info")
                        $Info = $Active;
                    if($_GET['Section']=="Horaire")
                        $Horaire = $Active;
                    if($_GET['Section']=="Confirm_Heures")
                        $Confirm_Heures = $Active;
                    if($_GET['Section']=="Joindre")
                        $Joindre = $Active;
                }
                
                ?>
                <li><a <?PHP echo $Welcome ?> href="index.php">Accueil</a></li>
                
                <li><a <?PHP echo $Horaire ?>  href="index.php?Section=Horaire">Mon Horaire</a></li>
                <li><a <?PHP echo $Info ?>  href="index.php?Section=Info">Mes Info</a></li>
                <li><a <?PHP echo $Liens ?>  href="index.php?Section=Confirm_Heures">Confirmation d'heures</a></li>
                <li><a <?PHP echo $Liens ?>  href="index.php?Action=Delog">Se D�connecter</a></li>
                                
            </ul>
            <div class="cl">&nbsp;</div>
        </div>
        <!-- end Navigation -->
    </div>
    <!-- end Header -->
    <!-- Main -->
      <div id="main">
        <!--<div class="attention">
            <p>ATTENTION!!! Le début de la session d'été commence! Assurez-vous de nous <a href="http://www.quebecnatation.com/index.php?Section=CV" target="_BLANK" style="link">envoyer votre CV!</a></p>
        </div> --><br>
       <?PHP
raisePresence();
 include('staff/menu.php'); 
	if(isset($_GET['Section']))
		$Section = $_GET['Section'];
	if(!isset($_GET['ToPrint']) OR !$_GET['ToPrint']){
?>
</TD>
<?PHP
}

?><td valign=top width=500><?PHP 
if(!isset($_COOKIE['IDEmploye'])){
	include('staff/login.php');
}  elseif (getnbconnections()>10) {
        include('toomuchconn.php');
}else{
	if(!isset($_REQUEST['Section']))
		$_REQUEST['Section'] = "Welcome";
	include('staff/section.php');
}
?>
    
    <!-- end Main -->
    
</div>
<!-- end Shell -->
<!-- Footer -->
    <div id="footer">
        <div class="shell">
            <p>Service de Sauveteurs inc. &copy; 2011 </p>
        </div>
    </div>
    <!-- end Footer -->
</body>
</html>