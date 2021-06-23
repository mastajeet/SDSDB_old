<?PHP
$MainOutput->br();
if(!isset($_GET['oldapp'])){
    $MainOutput->AddTexte('Bonjour à tous,
Pour vous connecter à l\'application, suivez le <a href="http://prod.qcnat.o2web.ws/">lien suivant</a>.<br>
Utilisez votre courriel comme nom d\'utilisateur et les 3 derniers chiffres de votre numéro d\'assurance sociale comme mot de passe!<br><br>

Pour vous connecter à l\'ancienne application, cliques <a href=?oldapp=1> ici</a><br>');

}else{
    $MainOutput->AddTexte('Veuillez saisir votre numéro d\'employé ainsi que les 3 derniers chiffre de votre numéro d\'assurance sociale (qui sont sur le papier que nous vous avons remis lors de la réunion).
        <b>Vous devez sélectionner si vous venez de Québec, Trois-Rivières ou Montréal!</b>');
}






$MainOutput->br(2);
?>