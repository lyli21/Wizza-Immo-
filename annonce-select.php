<?php 
include("header.php");

if (!$isAdminOrCommercial){
    header("Location: index.php");
    exit();
}

// déclaration des variables
$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$libelle = $idValue = '';
$idTypeBien = null;

// Création d'un tableau de type de bien avec une requête SQL recherchant les ids et libelles de la table waz_type_bien 
$typeBien = [];
$typeBien = $pdo->query("SELECT ty_bien_id, ty_bien_libelle FROM waz_type_bien")->fetchAll();

// si l'id est fourni, on récupère les informations du bien

if ($id !== ''){
    $sql = "SELECT * FROM waz_annonces a JOIN waz_type_bien b ON a.an_id = b.ty_bien_id WHERE a.an_id = $id";
    $result = $pdo->query($sql);
    $bien = $result->fetch(PDO::FETCH_ASSOC);

    // Si la requete SQL trouve les éléments on deffinit les variables pour les reliers au colonne sql sinon on indique que le produit es introuvable

}