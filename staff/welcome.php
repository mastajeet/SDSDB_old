<?PHP
$MainOutput->br();
if(!isset($_GET['oldapp'])){
    $MainOutput->AddTexte('Bonjour � tous,
Pour vous connecter � l\'application, suivez le <a href="http://prod.qcnat.o2web.ws/">lien suivant</a>.<br>
Utilisez votre courriel comme nom d\'utilisateur et les 3 derniers chiffres de votre num�ro d\'assurance sociale comme mot de passe!<br><br>

Pour vous connecter � l\'ancienne application, cliques <a href=?oldapp=1> ici</a><br>');

}else{
    $MainOutput->AddTexte('Veuillez saisir votre num�ro d\'employ� ainsi que les 3 derniers chiffre de votre num�ro d\'assurance sociale (qui sont sur le papier que nous vous avons remis lors de la r�union).
        <b>Vous devez s�lectionner si vous venez de Qu�bec, Trois-Rivi�res ou Montr�al!</b>');
}






$MainOutput->br(2);
?>