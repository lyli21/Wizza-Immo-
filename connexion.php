<?php 
include 'header.php';

// verifier si l'user est connecté
if(isset($_SESSION['user_id'])){
    header('Location: index.php'); // redirection a la page d'acceuil si connecté
    exit();
}

// si le formulaire est soumis
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // reception des données du formulaire
    $login = $_POST['user_login'];
    $password = $_POST['user_password'];

$stmt = $pdo->prepare("SELECT * FROM waz_user WHERE user_login = :user_login");
$stmt->bindValue(':user_login',$login);

$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['user_password'])){
    // Si connexion réussie stocker la les info user sur la variable de session
    $_SESSION['user_id'] = $user['id'];

    // recupere le type d'utilisateur pour renseigner la variable de dession ty_id
    $stmt = $pdo->prepare("SELECT * FROM waz_type_utilisateur WHERE ty_id = :ty_id");
    $stmt->bindValue(':ty_id',$user['ty_id']);
    $stmt->execute();
    $ty_user = $stmt->fetch(PDO::FETCH_ASSOC);

    // stock les info du type user dans la session 
    $_SESSION['ty_libelle'] = $ty_user['ty_libelle'];
    echo"<br>Type d'utilisateur : " . $_SESSION['ty_libelle'];
    $_SESSION['logged_in'] = true;
    echo'<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
} else {
    // Si identifiant incorrect affichage d'un message d'erreur
    $error_message = "Identifiant ou mot de passe incorrect";
}
}
?>

<div class="inscription-connexion">
    <h1 class="title">Connexion</h1>
    <?php if(isset($error_message)) : ?> 
        <div class="alert alert-danger" role="alert"></div>
        <p><?php echo $error_message;?></p>
</div>
<?php endif; ?>

<form method="POST" class="form">
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" id="login" name="user_login" placeholder="email" required>
    </div>
    <br>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="user_password" placeholder="mot de passe" required>
    </div>
    <div class="form-group">
    <br>
    <input type="submit" class="btn-connexion" value="Se connecter">
    </div>
 </div>
</form>

<?php include 'footer.php'; ?>
