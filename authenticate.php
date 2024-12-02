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
session_start();

// Configuration de la base de données
$host = 'localhost';
$dbname = 'darkweb_users';
$username = 'root';
$password = '';

header('Content-Type: application/json');

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']);
    exit();
}

// Récupérer les données de la requête POST
$data = json_decode(file_get_contents('php://input'), true);
$user = $data['username'] ?? '';
$pass = $data['password'] ?? '';

// Vérifier si les champs sont remplis
if (empty($user) || empty($pass)) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
    exit();
}

// Vérification des identifiants dans la base de données
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $test = password_hash("hacker", PASSWORD_BCRYPT);
    $test = password_hash("ghost1", PASSWORD_BCRYPT);

    if ($result && password_verify($pass, $result['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $result['username'];
        $_SESSION['role'] = $result['role'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nom d’utilisateur ou mot de passe incorrect.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la vérification des identifiants.']);
}
?>
