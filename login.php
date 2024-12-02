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
    <title>Login - Portail Darkweb</title>
    <style>
        body {
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            color: #0f0;
            background: #000;
            overflow: hidden;
        }

        /* Arrière-plan glitch */
        .glitch-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #0f0, #000, #0f0);
            background-size: 400% 400%;
            animation: glitch 5s infinite;
            opacity: 0.2;
            z-index: -1;
        }

        @keyframes glitch {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        header {
            text-align: center;
            margin-top: 50px;
            color: #0f0;
        }

        .login-container {
            width: 400px;
            max-width: 90%;
            margin: 100px auto;
            padding: 20px;
            background-color: rgba(17, 17, 17, 0.9);
            border: 2px solid #0f0;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
        }

        .login-container img {
            width: 80px;
            margin-bottom: 20px;
            border-radius: 50%;
            border: 2px solid #0f0;
        }

        .login-container h2 {
            color: #0f0;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #0f0;
            background-color: #222;
            color: #0f0;
            border-radius: 4px;
            outline: none;
        }

        .login-container input:focus {
            border-color: #ff0;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #0f0;
            border: none;
            color: #000;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .login-container button:hover {
            background: #ff0;
            color: #000;
        }

        .error-message {
            color: #f00;
            font-size: 14px;
            margin-top: 10px;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: rgba(0, 255, 0, 0.7);
        }
    </style>
</head>
<body>
    <div class="glitch-bg"></div>

    <header>
        <h1>Portail Darkweb</h1>
    </header>

    <div class="login-container">
        <img src="darkweb-logo.webp" alt="Logo Darkweb">
        <h2>Connexion Sécurisée</h2>
        <form id="loginForm">
            <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            <button type="button" id="loginButton">Connexion</button>
            <div class="error-message" id="errorMessage"></div>
        </form>
    </div>

    <footer>
        &copy; 2024 Darkweb Network. Stay Anonymous.
    </footer>

    <script>
        document.getElementById('loginButton').addEventListener('click', async () => {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');

            errorMessage.textContent = ''; // Clear any previous error message

            try {
                const response = await fetch('authenticate.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username, password })
                });

                const data = await response.json();

                if (data.success) {
                    // Redirection si la connexion est réussie
                    window.location.href = 'users.php';
                } else {
                    errorMessage.textContent = data.message || "Une erreur s'est produite.";
                }
            } catch (error) {
                errorMessage.textContent = "Impossible de se connecter au serveur.";
            }
        });
    </script>
</body>
</html>
