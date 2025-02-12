<?php include 'header.php'; ?>

<?php 

// Vérification si l'user est connecté 
if (isset($_SESSION['user_id'])){
    header('Location: index.php'); // Redirection si connecté
    exit();
}

// Traitement de la soumission du formulaire d'inscription
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Récupération des données du formulaire
    $login = $_POST['user_login'];
    $password = $_POST['user_password'];


    $stmt = $pdo->prepare("SELECT * FROM waz_user WHERE user_login = :user_login");
    $stmt->bindValue(':user_login',$login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user){
        // Si l'utilisateur existe déjà alors afficher un message d'erreur
        $error_message = "Cet utilisateur existe déjà";
    } else {
        // insertion de l'user dans la base de données
        $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash du mdp 
        $stmt = $pdo->prepare("INSERT INTO waz_user (user_login, user_password, ty_id)
        VALUES (:user_login, :user_password, 2)"); // force le type utilisateur a default
        $stmt->bindValue(':user_login', $login);
        $stmt->bindValue(':user_password', $password_hash);
        $stmt->execute();

        // recuperation de l'identifiant de l'user inséré
        $user_id = $pdo->lastInsertId();
        // connexion auto apres l'inscription
        $_SESSION['user_id'] = $user_id;

        header('Location: index.php'); // Redirection vers la page d'accueil
        exit();
    }
}

?>

<div class="inscription-connexion">
    <h1 class="title">Inscription</h1>
    <?php if(isset($error_message)) : ?> 
        <p><?php echo $error_message;?></p>
</div>
<?php endif; ?>

<form method="POST" class="form">
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" id="login" name="user_login" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="user_password" required>
    </div>
    <div class="form-group">
        <input type="submit" value="S'inscrire">
    </div>
    <a href="connexion.php" class="link-login">Déjà inscrit? Connectez-vous</a>
 </div>
</form>

<?php include 'footer.php'; ?>
