<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de Production</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #28a745;
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Liste de Production Consolidée</h1>
    <div class="container">
        <?php
        $filename = "production.csv";

        if (file_exists($filename)) {
            echo "<table>";
            echo "<thead><tr><th>Pain</th><th>Poids (Kg)</th><th>Quantité</th></tr></thead>";
            echo "<tbody>";

            $handle = fopen($filename, "r");
            while (($row = fgetcsv($handle)) !== false) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row[0]) . "</td>";
                echo "<td>" . htmlspecialchars($row[1]) . "</td>";
                echo "<td>" . htmlspecialchars($row[2]) . "</td>";
                echo "</tr>";
            }
            fclose($handle);

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Aucune production enregistrée.</p>";
        }
        ?>
    </div>
</body>
</html>
