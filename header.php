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

if(session_status()=== PHP_SESSION_NONE){
    session_start();
}

// configuration de la base données dans le header et sera accessible partout grace au include
$host = '127.0.0.1';
$dbname = 'wazzaimmo';
$username = 'root';
$password = '';

try {
    // connexion à la base donnée
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion :" . $e->getMessage());
}

// vérifier si l'utilisateur est connecté
$username = null;
if(isset($_SESSION['user_id'])){
    $userId = $_SESSION['user_id'];

// récuperer les informations de l'utilisateur connecté pour gerer les droits
$sqlUser = "SELECT * FROM waz_user WHERE user_id = :user_id";
$stmtUser = $pdo ->prepare($sqlUser);
$stmtUser->execute(['user_id' => $userId]);

$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if($user){
    $username = $user['user_id'];
}
}

// Vérifier si l'user et admin ou commercial 
$isAdminOrCommercial = isset($_SESSION['ty_libelle']) && in_array($_SESSION['ty_libelle'], ['admin', 'commercial']);

if(isset($_SESSION['ty_libelle'])){
    switch(strtolower($_SESSION['ty_libelle'])){
        case 'admin':
            echo 'Acces admin';
            break;
        case 'commercial':
           echo 'Acces commercial';
            break;
        default:
            echo ' default';
            break;
    }
} else {
        echo 'default';
    }
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
    <!-- button connexion deconnexion -->
     <?php if($username): ?>
        <button>
        <a href="deconnexion.php" class="lien">Deconnexion</a>
    </button>
    <?php else:?>
    <button>
        <a href="connexion.php" class="lien">Connexion</a>
    </button>
    <?php endif; ?>
    </nav>
</header> 
