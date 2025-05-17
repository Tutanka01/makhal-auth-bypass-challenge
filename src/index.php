<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo "<h1>Bienvenue dans le Système d'Administration Sécurisé</h1>";
    echo "<p>Félicitations ! Vous avez réussi à accéder au système. Voici votre flag : <strong>" . htmlspecialchars(file_get_contents("lkhqsdmlfkkh/flag.txt")) . "</strong></p>";
    echo "<hr><p>Challenge CTF - Niveau Débutant</p>";
} else {
    echo "<h1>Système d'Administration Sécurisé</h1>";
    echo "<p>Seuls les administrateurs peuvent accéder à ce système.</p>";
    echo '<form method="POST" action="login.php">';
    echo 'Nom d\'utilisateur: <input name="username"><br>';
    echo 'Mot de passe: <input name="password" type="password"><br>';
    echo '<!-- Note pour les développeurs: N\'oubliez pas que le système utilise maintenant la vérification à deux facteurs. -->';
    echo '<input type="submit" value="Connexion">';
    echo '</form>';
    echo '<p><small>v2.0 - Protocole d\'authentification mis à jour.</small></p>';
}
?>