<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données
    $nom = $_POST["nom"] ?? '';
    $prenom = $_POST["prenom"] ?? '';
    $commandes = json_decode($_POST["commandes"], true);

    if (!$nom || !$prenom || !$commandes) {
        echo "Données incomplètes.";
        exit;
    }

    // Fichier des commandes répertoriées
    $fichierCommandes = "commandes.csv";
    $fichierProduction = "production.csv";

    // Ouverture des fichiers
    $commandeHandle = fopen($fichierCommandes, "a");
    $productionHandle = fopen($fichierProduction, "a");

    $productionPains = [];

    foreach ($commandes as $commande) {
        // Données pour commandes.csv
        $ligneCommande = [
            $nom,
            $prenom,
            $commande["pain"],
            $commande["poids"],
            $commande["quantite"],
            $commande["prix"]
        ];
        fputcsv($commandeHandle, $ligneCommande);

        // Organisation par pain pour production.csv
        $clePain = $commande["pain"] . "-" . $commande["poids"];
        if (!isset($productionPains[$clePain])) {
            $productionPains[$clePain] = 0;
        }
        $productionPains[$clePain] += $commande["quantite"];
    }

    fclose($commandeHandle);

    // Ecrire les données consolidées dans production.csv
    foreach ($productionPains as $clePain => $quantite) {
        list($pain, $poids) = explode("-", $clePain);
        fputcsv($productionHandle, [$pain, $poids, $quantite]);
    }

    fclose($productionHandle);

    echo "Commandes enregistrées avec succès.";
} else {
    echo "Méthode non autorisée.";
}
?>
