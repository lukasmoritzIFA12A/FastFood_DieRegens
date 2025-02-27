<?php
    $details = $details ?? "Keine Details";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verbindungsfehler</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 100px;
            text-align: center;
        }
        .error-box {
            max-height: 200px; /* Maximalhöhe für das Scrollen */
            overflow-y: auto; /* Scrollbar bei Überlauf */
            border: 1px solid #dc3545; /* Rahmen für die Box */
            background-color: #f8d7da; /* Hintergrundfarbe */
            padding: 15px; /* Innenabstand */
            border-radius: 5px; /* Abgerundete Ecken */
            margin-top: 20px; /* Abstand zur oberen Box */
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="display-4 text-danger">Verbindungsfehler</h1>
    <p class="lead">Die Verbindung zur Website ist fehlgeschlagen.</p>
    <p>Bitte kontaktieren Sie den Administrator für weitere Unterstützung.</p>
    <a href="mailto:lukas.moritz@bs-erlangen.de" class="btn btn-primary">Administrator kontaktieren</a>

    <div class="error-box" id="errorDetails">
        <h5>Fehlerdetails:</h5>
        <pre>
            <?= $details ?>
        </pre>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>