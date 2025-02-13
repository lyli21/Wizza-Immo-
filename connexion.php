<?php
include 'header.php';

// Vérifier si l'utilisateur est connecté
if(isset($_SESSION['user_id'])){
    header('Location: index.php'); // Redirection à la page d'accueil si connecté
    exit();
}

// Si le formulaire est soumis
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Réception des données du formulaire
    $login = $_POST['user_login'];
    $password = $_POST['user_password'];

    $stmt = $pdo->prepare("SELECT * FROM waz_utilisateur WHERE user_login = :user_login");
    $stmt->bindValue(':user_login', $login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['user_password'])){
        // Si connexion réussie, stocker les informations de l'utilisateur dans la variable de session
        $_SESSION['user_id'] = $user['user_id'];

        // Récupérer le type d'utilisateur pour renseigner la variable de session ty_libelle
        $stmt = $pdo->prepare("SELECT * FROM waz_user WHERE ty_user_id = :ty_user_id");
        $stmt->bindValue(':ty_user_id', $user['ty_user_id']);
        $stmt->execute();
        $ty_user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Stocker les informations du type d'utilisateur dans la session
        $_SESSION['ty_libelle'] = $ty_user['ty_libelle'];
        $_SESSION['logged_in'] = true;

        header('Location: index.php'); // Redirection vers la page d'accueil
        exit();
    } else {
        // Si identifiant incorrect, affichage d'un message d'erreur
        $error_message = "Identifiant ou mot de passe incorrect";
    }
}
?>

<div class="inscription-connexion">
    <h1 class="title">Connexion</h1>
    <?php if(isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <p><?php echo $error_message; ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="form">
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" id="login" name="user_login" placeholder="Email" required>
            <br>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="user_password" placeholder="Mot de passe" required>
            <br>
            <input type="submit" class="btn-connexion" value="Se connecter">
        </div>
    </form>
    <p class="text-center">Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
</div>

<?php include 'footer.php'; ?>
