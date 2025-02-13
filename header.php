<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wazza'Immo</title>
    <link rel="stylesheet" href="/styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Configuration de la base de données dans le header et sera accessible partout grâce au include
$host = '127.0.0.1';
$dbname = 'wazzaimmo';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si l'utilisateur est connecté
$username = null;
if(isset($_SESSION['user_id'])){
    $userId = $_SESSION['user_id'];

    // Récupérer les informations de l'utilisateur connecté pour gérer les droits
    $sqlUser = "SELECT * FROM waz_utilisateur WHERE user_id = :user_id";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->execute(['user_id' => $userId]);

    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if($user){
        $username = $user['user_login']; // Utilisez user_login pour afficher le nom d'utilisateur
    }
}

// Vérifier si l'utilisateur est admin ou commercial
$isAdminOrCommercial = isset($_SESSION['ty_libelle']) && in_array($_SESSION['ty_libelle'], ['admin', 'commercial']);

if(isset($_SESSION['ty_libelle'])){
    switch(strtolower($_SESSION['ty_libelle'])){
        case 'admin':
            echo 'Accès admin';
            break;
        case 'commercial':
            echo 'Accès commercial';
            break;
        default:
            echo 'Accès par défaut';
            break;
    }
} else {
    echo 'Accès par défaut';
}

// Messages de débogage
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "User ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not set') . "\n";
echo "Username: " . ($username ? $username : 'Not set') . "\n";
echo "</pre>";
?>

<header>
    <nav class="navigation">
        <a href="index.php">
            <img src="./photos/wazaa_logo.png" class="taille" alt="logo de l'agence wazza immo">
        </a>
        <button>
            <a href="index.php" class="lien">Accueil</a>
        </button>
        <button>
            <a href="contact.php" class="lien">Contact</a>
        </button>
        <button>
            <a href="apropos.php" class="lien">A propos</a>
        </button>
        <!-- Boutons de connexion/déconnexion -->
        <?php if($username): ?>
            <button>
                <a href="logout.php" class="lien">Déconnexion</a>
            </button>
        <?php else: ?>
            <button>
                <a href="connexion.php" class="lien">Connexion</a>
            </button>
        <?php endif; ?>
    </nav>
</header>
</body>
</html>
