<?php
$host = '127.0.0.1';
$dbname = 'wazzaimmo';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion :" . $e->getMessage());
}

include 'header.php';

// Requête sql pour afficher les annonces
$sql = "SELECT DISTINCT wa.*, wp.photos_libelle, wto.offre_libelle FROM waz_annonces wa LEFT 
        JOIN peut_contenir pc ON wa.an_id = pc.an_id LEFT JOIN waz_photos wp ON pc.photos_id = wp.photos_id 
        LEFT JOIN waz_type_offre wto ON wa.ty_offre_id = wto.ty_offre_id
WHERE 
    wa.etat_id = 1";

try {
    $annonces = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de requête : " . $e->getMessage();
    $annonces = [];
}

// Vérifier si la table waz_ann_etat a des données
$checkEtat = "SELECT COUNT(*) FROM waz_ann_etat";
$count = $pdo->query($checkEtat)->fetchColumn();

if ($count == 0) {
    // Insérer les états si la table est vide
    $pdo->exec("INSERT INTO waz_ann_etat (etat_id, etat_libelle) VALUES (1, true), (2, false)");
}
?>

<!-- Ajout d'un titre -->
<div class="container mt-4">
    <h1 class="mb-4">Nos biens immobiliers</h1>

    <!-- Liste des annonces -->
    <div class="row">
        <?php if(empty($annonces)): ?>
            <div class="col-12">
                <div class="alert alert-info">Aucune annonce disponible pour le moment.</div>
            </div>
        <?php else: ?>
            <?php foreach ($annonces as $annonce): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php 
                        $imagePath = !empty($annonce['photos_libelle']) 
                            ? "uploads/" . htmlspecialchars($annonce['photos_libelle'])
                            : "photos/annonce_1/1-1.jpg";
                        ?>
                        <img src="<?= $imagePath ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($annonce['an_titre']) ?>"
                             onerror="this.src='photos/annonce_1/1-1.jpg'">

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($annonce['an_titre']) ?></h5>
                            <div class="badge bg-primary mb-2">
                                <?= $annonce['offre_libelle'] === 'A' ? 'Achat' : 
                                   ($annonce['offre_libelle'] === 'L' ? 'Location' : 'Viager') ?>
                            </div>
                            <p class="card-text">
                                <strong>Prix : </strong><?= number_format($annonce['an_prix'], 0, ',', ' ') ?> €<br>
                                <strong>Surface : </strong><?= htmlspecialchars($annonce['an_surf_hab']) ?> m²<br>
                                <strong>Localisation : </strong><?= htmlspecialchars($annonce['an_localisation']) ?>
                            </p>

                            <p class="card-text text-muted">
                                <?= mb_substr(htmlspecialchars($annonce['an_description']), 0, 100) ?>...
                            </p>
                        </div>

                        <div class="card-footer bg-white border-top-0">
                            <a href="annonce.php?id=<?= $annonce['an_id'] ?>"
                               class="btn btn-primary">Voir détails</a>
                            <?php if (isset($isAdminOrCommercial) && $isAdminOrCommercial): ?>
                                <a href="annonce.php?id=<?= $annonce['an_id'] ?>"
                                   class="btn btn-warning">Modifier</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}

.badge {
    font-size: 0.9em;
}
</style>