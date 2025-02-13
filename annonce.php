<?php
include 'header.php';

// Connexion à la base de données
$host = 'localhost';
$dbname = 'wazzaimmo';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des types de biens
$typeBiens = $pdo->query("SELECT * FROM waz_type_bien")->fetchAll();
$typeOffres = $pdo->query("SELECT * FROM waz_type_offre")->fetchAll();

// Initialisation des variables
$titre = $description = $localisation = $surfaceHab = $surfaceTot = $prix = $diagnostic = '';
$pieces = $typeBien = $typeOffre = '';
$message = '';

// Si on modifie une annonce existante
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM waz_annonces WHERE an_id = ?");
    $stmt->execute([$id]);
    $annonce = $stmt->fetch();
    
    if($annonce) {
        $titre = $annonce['an_titre'];
        $description = $annonce['an_description'];
        $localisation = $annonce['an_localisation'];
        $surfaceHab = $annonce['an_surf_hab'];
        $surfaceTot = $annonce['an_surf_tot'];
        $prix = $annonce['an_prix'];
        $diagnostic = $annonce['an_diagnostic'];
        $pieces = $annonce['an_pieces'];
        $typeBien = $annonce['ty_bien_id'];
        $typeOffre = $annonce['ty_offre_id'];
    }
}

// Traitement du formulaire
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $localisation = $_POST['localisation'];
    $surfaceHab = $_POST['surfaceHab'];
    $surfaceTot = $_POST['surfaceTot'];
    $prix = $_POST['prix'];
    $diagnostic = $_POST['diagnostic'];
    $pieces = $_POST['pieces'];
    $typeBien = $_POST['typeBien'];
    $typeOffre = $_POST['typeOffre'];

    try {
        if(isset($_GET['id'])) {
            // Mise à jour d'une annonce existante
            $sql = "UPDATE waz_annonces SET 
                    an_titre = ?, 
                    an_description = ?,
                    an_localisation = ?,
                    an_surf_hab = ?,
                    an_surf_tot = ?,
                    an_prix = ?,
                    an_diagnostic = ?,
                    an_pieces = ?,
                    ty_bien_id = ?,
                    ty_offre_id = ?,
                    an_d_modif = NOW(),
                    etat_id = 1
                    WHERE an_id = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $description, $localisation, $surfaceHab, $surfaceTot, 
                          $prix, $diagnostic, $pieces, $typeBien, $typeOffre, $_GET['id']]);
        } else {
            // Création d'une nouvelle annonce
            $sql = "INSERT INTO waz_annonces (an_titre, an_description, an_localisation, 
                    an_surf_hab, an_surf_tot, an_prix, an_diagnostic, an_pieces, 
                    ty_bien_id, ty_offre_id, an_d_ajout, an_d_modif, etat_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 1)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $description, $localisation, $surfaceHab, $surfaceTot, 
                          $prix, $diagnostic, $pieces, $typeBien, $typeOffre]);
        }
        
        header('Location: index.php');
        exit();
    } catch(PDOException $e) {
        $message = "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
}
?>

<div class="container mt-4">
    <h1><?= isset($_GET['id']) ? 'Modifier' : 'Ajouter' ?> une annonce</h1>
    
    <?php if($message): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?= $titre ?>" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="localisation" class="form-label">Localisation</label>
                <input type="text" class="form-control" id="localisation" name="localisation" value="<?= $localisation ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="surfaceHab" class="form-label">Surface habitable (m²)</label>
                <input type="number" class="form-control" id="surfaceHab" name="surfaceHab" value="<?= $surfaceHab ?>" required>
            </div>
            
            <div class="col-md-4 mb-3">
                <label for="surfaceTot" class="form-label">Surface totale (m²)</label>
                <input type="number" class="form-control" id="surfaceTot" name="surfaceTot" value="<?= $surfaceTot ?>" required>
            </div>
            
            <div class="col-md-4 mb-3">
                <label for="prix" class="form-label">Prix (€)</label>
                <input type="number" class="form-control" id="prix" name="prix" value="<?= $prix ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="pieces" class="form-label">Nombre de pièces</label>
                <input type="number" class="form-control" id="pieces" name="pieces" value="<?= $pieces ?>" required>
            </div>
            
            <div class="col-md-4 mb-3">
                <label for="typeBien" class="form-label">Type de bien</label>
                <select class="form-control" id="typeBien" name="typeBien" required>
                    <?php foreach($typeBiens as $type): ?>
                        <option value="<?= $type['ty_bien_id'] ?>" <?= $typeBien == $type['ty_bien_id'] ? 'selected' : '' ?>>
                            <?= $type['ty_bien_libelle'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-4 mb-3">
                <label for="typeOffre" class="form-label">Type d'offre</label>
                <select class="form-control" id="typeOffre" name="typeOffre" required>
                    <?php foreach($typeOffres as $offre): ?>
                        <option value="<?= $offre['ty_offre_id'] ?>" <?= $typeOffre == $offre['ty_offre_id'] ? 'selected' : '' ?>>
                            <?= $offre['offre_libelle'] == 'A' ? 'Achat' : 
                               ($offre['offre_libelle'] == 'L' ? 'Location' : 'Viager') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="diagnostic" class="form-label">Diagnostic énergétique (A à G)</label>
            <input type="text" class="form-control" id="diagnostic" name="diagnostic" value="<?= $diagnostic ?>" maxlength="1" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required><?= $description ?></textarea>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary"><?= isset($_GET['id']) ? 'Modifier' : 'Ajouter' ?></button>
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>