<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes Enregistrées</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .client-section {
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 16px;
            text-align: left;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Liste des Commandes Enregistrées</h1>
    <div class="container">
        <?php
        $filename = "commandes.csv";

        if (file_exists($filename)) {
            // Regrouper les commandes par client
            $clients = [];
            $handle = fopen($filename, "r");

            while (($row = fgetcsv($handle)) !== false) {
                [$nom, $prenom, $pain, $poids, $quantite, $prix] = $row;
                $clientKey = $nom . " " . $prenom;

                if (!isset($clients[$clientKey])) {
                    $clients[$clientKey] = [
                        "nom" => $nom,
                        "prenom" => $prenom,
                        "commandes" => [],
                        "total" => 0
                    ];
                }

                $clients[$clientKey]["commandes"][] = [
                    "pain" => $pain,
                    "poids" => $poids,
                    "quantite" => $quantite,
                    "prix" => $prix
                ];

                $clients[$clientKey]["total"] += $prix;
            }

            fclose($handle);

            // Afficher les commandes par client
            foreach ($clients as $client) {
                echo "<div class='client-section'>";
                echo "<h2>Client : " . htmlspecialchars($client["nom"]) . " " . htmlspecialchars($client["prenom"]) . "</h2>";
                echo "<table>";
                echo "<thead><tr><th>Pain</th><th>Poids (Kg)</th><th>Quantité</th><th>Prix (€)</th></tr></thead>";
                echo "<tbody>";

                foreach ($client["commandes"] as $commande) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($commande["pain"]) . "</td>";
                    echo "<td>" . htmlspecialchars($commande["poids"]) . "</td>";
                    echo "<td>" . htmlspecialchars($commande["quantite"]) . "</td>";
                    echo "<td>" . htmlspecialchars($commande["prix"]) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
                echo "<p class='total'>Total pour " . htmlspecialchars($client["nom"]) . " : " . number_format($client["total"], 2) . " €</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune commande enregistrée.</p>";
        }
        ?>
    </div>
</body>
</html>
