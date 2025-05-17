<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// Récupération des données du formulaire
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$token = isset($_POST['2fa_token']) ? $_POST['2fa_token'] : '';
$auth_method = isset($_POST['auth_method']) ? $_POST['auth_method'] : 'password';

// Fonction de journalisation des tentatives de connexion
function log_login_attempt($username, $status, $method) {
    $log_entry = date("Y-m-d H:i:s") . " - Utilisateur: $username, Méthode: $method, Statut: $status\n";
    // Décommentez cette ligne en production pour activer la journalisation
    // file_put_contents("../logs/access.log", $log_entry, FILE_APPEND);
}

// Identifiants corrects pour l'administrateur
$admin_username = "admin";
$admin_password = "S3cur3P@ssw0rd!";  // Mot de passe fort qui ne peut pas être deviné facilement
$valid_2fa_token = "123456";  // Token 2FA dans un cas réel serait généré et vérifié dynamiquement

// Vérification de l'authentification
if ($auth_method === 'password') {
    // Méthode d'authentification par mot de passe standard
    if ($username === $admin_username && $password === $admin_password) {
        // Mot de passe correct, mais il manque l'authentification à 2 facteurs
        echo "<h1>Authentification à deux facteurs requise</h1>";
        echo "<p>Pour des raisons de sécurité, veuillez entrer votre code d'authentification à deux facteurs.</p>";
        echo '<form method="POST" action="login.php">';
        echo '<input type="hidden" name="username" value="' . htmlspecialchars($username) . '">';
        echo '<input type="hidden" name="auth_method" value="2fa">';
        echo 'Code 2FA: <input name="2fa_token"><br>';
        echo '<input type="submit" value="Vérifier">';
        echo '</form>';
        log_login_attempt($username, "2FA requise", "password");
    } else {
        // Identifiants incorrects
        echo "<h1>Échec de l'authentification</h1>";
        echo "<p>Nom d'utilisateur ou mot de passe incorrect.</p>";
        echo '<p><a href="index.php">Retour à la page de connexion</a></p>';
        log_login_attempt($username, "échec", "password");
    }
} elseif ($auth_method === '2fa') {
    // Méthode d'authentification par 2FA
    if ($token === $valid_2fa_token) {
        // Authentification réussie
        $_SESSION['logged_in'] = true;
        log_login_attempt($username, "succès", "2fa");
        header("Location: index.php");
        exit;
    } else {
        // Code 2FA incorrect
        echo "<h1>Échec de l'authentification</h1>";
        echo "<p>Code d'authentification à deux facteurs incorrect.</p>";
        echo '<p><a href="index.php">Retour à la page de connexion</a></p>';
        log_login_attempt($username, "échec", "2fa");
    }
} elseif ($auth_method === 'legacy') {
    // Ancienne méthode d'authentification (vulnérable)
    // Cette méthode a été "désactivée" mais le code existe toujours
    if ($username === $admin_username) {
        // L'ancienne méthode ne vérifie que le nom d'utilisateur
        $_SESSION['logged_in'] = true;
        log_login_attempt($username, "succès", "legacy");
        header("Location: index.php");
        exit;
    } else {
        echo "<h1>Échec de l'authentification</h1>";
        echo "<p>Méthode d'authentification non prise en charge.</p>";
        echo '<p><a href="index.php">Retour à la page de connexion</a></p>';
        log_login_attempt($username, "échec", "legacy");
    }
} else {
    // Méthode d'authentification inconnue
    echo "<h1>Erreur</h1>";
    echo "<p>Méthode d'authentification non reconnue.</p>";
    echo '<p><a href="index.php">Retour à la page de connexion</a></p>';
    log_login_attempt("inconnu", "erreur", "inconnue");
}

// Commentaires pour les développeurs (visible dans le code source)
echo "<!-- 
    Notes de développement:
    - Ancienne API d'authentification toujours présente pour la compatibilité avec les systèmes legacy
    - À FAIRE: Supprimer le support de la méthode 'legacy' dans la v2.1
    - Référence API: auth_method peut être 'password', '2fa', ou 'legacy'
-->";
?>