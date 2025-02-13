<?php
include 'header.php';

// Vérification si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirection si connecté
    exit();
}

// Traitement de la soumission du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $login = $_POST['user_login'];
    $password = $_POST['user_password'];

    try {
        // Vérification si l'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT * FROM waz_utilisateur WHERE user_login = :user_login");
        $stmt->bindValue(':user_login', $login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Si l'utilisateur existe déjà, afficher un message d'erreur
            $error_message = "Cet utilisateur existe déjà";
        } else {
            // Insertion de l'utilisateur dans la base de données
            $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash du mot de passe
            $stmt = $pdo->prepare("INSERT INTO waz_utilisateur (user_login, user_password, ty_user_id) VALUES (:user_login, :user_password, 2)"); // Force le type utilisateur à default
            $stmt->bindValue(':user_login', $login);
            $stmt->bindValue(':user_password', $password_hash);
            $stmt->execute();

            // Récupération de l'identifiant de l'utilisateur inséré
            $user_id = $pdo->lastInsertId();
            // Connexion automatique après l'inscription
            $_SESSION['user_id'] = $user_id;

            header('Location: index.php'); // Redirection vers la page d'accueil
            exit();
        }
    } catch (PDOException $e) {
        // Gestion des erreurs de base de données
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<div class="inscription-connexion">
    <h1 class="title">Inscription</h1>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST" class="form">
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" id="login" name="user_login" required placeholder="Email">

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="user_password" required placeholder="Mot de passe">

            <input type="submit" value="S'inscrire">
        </div>
        <p class="text-center"><a href="connexion.php">Déjà inscrit ? Connectez-vous</a></p>
    </form>
</div>

<?php include 'footer.php'; ?>
