<?php
include 'header.php';

// Connexion à la base de données (garder cette partie)
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

// Vérification et récupération de l'annonce (garder cette partie)
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT wa.*, wp.photos_libelle, wtb.ty_bien_libelle, wto.offre_libelle
        FROM waz_annonces wa 
        LEFT JOIN peut_contenir pc ON wa.an_id = pc.an_id 
        LEFT JOIN waz_photos wp ON pc.photos_id = wp.photos_id
        LEFT JOIN waz_type_bien wtb ON wa.ty_bien_id = wtb.ty_bien_id
        LEFT JOIN waz_type_offre wto ON wa.ty_offre_id = wto.ty_offre_id
        WHERE wa.an_id = ? AND wa.etat_id = 1";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $annonce = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$annonce) {
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Chemin de l'image
$imagePath = "photos/annonce" . $annonce['an_id'] . "/" . $annonce['an_id'] . "-1.jpg";
?>


<div class="detail-container">
    <a href="index.php">Retour à la liste</a>
    
    <h1 class="titre-annonce"><?= htmlspecialchars($annonce['an_titre']) ?></h1>
    
    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($annonce['an_titre']) ?>" class="image-annonce">


    
    <div class="type-offre">
        <?= $annonce['offre_libelle'] === 'A' ? 'Achat' : 
           ($annonce['offre_libelle'] === 'L' ? 'Location' : 'Viager') ?>
        - <?= htmlspecialchars($annonce['ty_bien_libelle']) ?>
    </div>
    
    <div class="prix">
        <?= number_format($annonce['an_prix'], 0, ',', ' ') ?> €
        <?= $annonce['offre_libelle'] === 'L' ? '/mois' : '' ?>
    </div>
    
    <div class="caracteristiques">
        <h2>Caractéristiques</h2>
        <p>Surface habitable : <?= htmlspecialchars($annonce['an_surf_hab']) ?> m²</p>
        <p>Surface totale : <?= htmlspecialchars($annonce['an_surf_tot']) ?> m²</p>
        <p>Nombre de pièces : <?= htmlspecialchars($annonce['an_pieces']) ?></p>
        <p>Localisation : <?= htmlspecialchars($annonce['an_localisation']) ?></p>
        <p>Diagnostic énergétique : <?= strtoupper(htmlspecialchars($annonce['an_diagnostic'])) ?></p>
    </div>
    
    <div class="description">
        <h2>Description</h2>
        <?= nl2br(htmlspecialchars($annonce['an_description'])) ?>
    </div>
    
    <?php if (isset($isAdminOrCommercial) && $isAdminOrCommercial): ?>
        <a href="annonce.php?id=<?= $annonce['an_id'] ?>" class="btn-modifier">Modifier l'annonce</a>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>