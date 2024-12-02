<?php
// Récupérer le User-Agent envoyé par le client
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Vérifier si le User-Agent correspond à "Fsociety"
if ($userAgent !== "fsociety") {
    // Rediriger vers index.html si le User-Agent est incorrect
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Protégé</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #000;
            color: #0f0;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #111;
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #0f0;
        }
        header h1 {
            margin: 0;
            color: #0f0;
        }
        main {
            padding: 20px;
        }
        .forum-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #111;
            padding: 20px;
            border: 2px solid #0f0;
            border-radius: 8px;
        }
        .forum-title {
            text-align: center;
            margin: 0;
            color: #0f0;
        }
        .post {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #0f0;
        }
        .post h3, .post p {
            margin: 0;
        }
        .new-post {
            margin-top: 20px;
        }
        .new-post input, .new-post textarea, .button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #222;
            color: #0f0;
            border: 1px solid #0f0;
            border-radius: 4px;
        }
        .new-post button, .button {
            cursor: pointer;
        }
        .new-post button:hover, .button:hover {
            background-color: #0f0;
            color: #000;
        }
        .login-button-container {
            margin: 20px 0;
            text-align: center;
        }
        .login-button-container .button {
            max-width: 200px;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <h1>Forum des Utilisateurs - Accès Restreint</h1>
    </header>
    <main>
        <div class="forum-container">
            <h2 class="forum-title">Bienvenue dans l'espace protégé</h2>

            <div class="post">
                <h3>Utilisateur : Admin</h3>
                <p>Message : Bienvenue dans cet espace réservé !</p>
            </div>
            <div class="post">
                <h3>Utilisateur : Hacker42</h3>
                <p>Message : Nous sommes anonymes. Nous sommes légion.</p>
            </div>

            <div class="new-post">
                <h3>Ajouter un message</h3>
                <form action="post_message.php" method="POST">
                    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                    <textarea name="message" placeholder="Message" rows="4" required></textarea>
                    <button type="submit">Envoyer</button>
                </form>
            </div>
        </div>

        <div class="login-button-container">
            <a href="login.php" class="button">Se connecter</a>
        </div>
    </main>
</body>
</html>
