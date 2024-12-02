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
<?php
// Récupérer le User-Agent envoyé par le client
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Vérifier si le User-Agent correspond à "Fsociety"
if ($userAgent !== "fsociety") {
    // Rediriger vers index.html si le User-Agent est incorrect
    header("Location: index.html");
    exit();
}

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'utilisateur est administrateur
$isAdmin = ($_SESSION['role'] === 'admin');

// Connexion à la base de données
$host = 'localhost';
$dbname = 'darkweb_users';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les utilisateurs pour les administrateurs
$users = [];
if ($isAdmin) {
    $stmt = $pdo->query("SELECT username, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les posts
$posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Mise à jour du mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE username = :username");
    $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
    $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->execute();
    $message = "Votre mot de passe a été mis à jour avec succès.";
}

// Ajout d'un post avec fichier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_content'])) {
    $username = $_SESSION['username'];
    $postContent = htmlspecialchars($_POST['post_content']);
    $filePath = null;

    // Gestion de l'upload de fichier
    if (!empty($_FILES['file']['name'])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['file']['name']); // Vulnérabilité intentionnelle
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $filePath = $targetFile;
        } else {
            $uploadError = "Erreur lors du téléchargement du fichier.";
        }
    }

    // Enregistrement dans la base de données
    $stmt = $pdo->prepare("INSERT INTO posts (username, content, file_path) VALUES (:username, :content, :file_path)");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':content', $postContent, PDO::PARAM_STR);
    $stmt->bindParam(':file_path', $filePath, PDO::PARAM_STR);
    $stmt->execute();
    $postMessage = "Votre post a été ajouté avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
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
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #111;
            border-bottom: 2px solid #0f0;
        }

        nav button {
            flex: 1;
            padding: 10px;
            background-color: #111;
            color: #0f0;
            border: none;
            cursor: pointer;
        }

        nav button:hover,
        nav button.active {
            background-color: #222;
            color: #ff0;
        }

        section {
            display: none;
            padding: 20px;
        }

        section.active {
            display: block;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #0f0;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #111;
        }

        form input,
        form textarea,
        form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #222;
            color: #0f0;
            border: 1px solid #0f0;
            border-radius: 4px;
        }

        form button {
            background-color: #0f0;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }

        form button:hover {
            background-color: #ff0;
            color: #000;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll("nav button");
            const sections = document.querySelectorAll("section");

            buttons.forEach((button, index) => {
                button.addEventListener("click", () => {
                    sections.forEach(sec => sec.classList.remove("active"));
                    buttons.forEach(btn => btn.classList.remove("active"));

                    sections[index].classList.add("active");
                    button.classList.add("active");
                });
            });

            // Activer le premier onglet par défaut
            buttons[0].classList.add("active");
            sections[0].classList.add("active");
        });
    </script>
</head>

<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
    </header>
    <nav>
        <button>Changer mon mot de passe</button>
        <?php if ($isAdmin): ?>
            <button>Voir les utilisateurs</button>
        <?php endif; ?>
        <button>Ajouter un post</button>
        <button>Voir les posts</button>
    </nav>

    <main>
        <!-- Onglet : Changer mot de passe -->
        <section>
            <h2>Changer votre mot de passe</h2>
            <?php if (isset($message)) echo "<p style='color: #0f0;'>$message</p>"; ?>
            <form method="POST">
                <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
                <button type="submit">Mettre à jour</button>
            </form>
        </section>

        <!-- Onglet : Voir les utilisateurs (admin uniquement) -->
        <?php if ($isAdmin): ?>
            <section>
                <h2>Liste des utilisateurs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom d'utilisateur</th>
                            <th>Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>

        <!-- Onglet : Ajouter un post -->
        <section>
            <h2>Ajouter un post</h2>
            <?php if (isset($postMessage)) echo "<p class='post-message'>$postMessage</p>"; ?>
            <?php if (isset($uploadError)) echo "<p class='upload-error'>$uploadError</p>"; ?>

            <form method="POST" enctype="multipart/form-data">
                <textarea name="post_content" placeholder="Écrivez votre message ici..." rows="5" required></textarea>
                <input type="file" name="file">
                <button type="submit">Publier</button>
            </form>
        </section>

        <!-- Onglet : Voir les posts -->
        <section>
            <h2>Liste des posts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Contenu</th>
                        <th>Fichier</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['username']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($post['content'])); ?></td>
                            <td>
                                <?php if ($post['file_path']): ?>
                                    <a href="<?php echo htmlspecialchars($post['file_path']); ?>" target="_blank">Voir le fichier</a>
                                <?php else: ?>
                                    Aucun fichier
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>
