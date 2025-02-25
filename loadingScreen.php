<?php
$welcomeMessage = "Willkommen auf meiner PHP-Seite!";
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixierte Logos mit PHP</title>
    <link rel="stylesheet" href="style.css">  <!-- Verlinkung der externen CSS-Datei -->ö

        /* ZENTRIERTER CONTAINER */
        .container {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        h1 {
            position: absolute;
            top: 10%; /* 10% von der Bildschirmhöhe */
            left: 50%; /* 50% von der Bildschirmbreite */
            transform: translateX(-50%); /* Korrektur für exakte Zentrierung */
        }


        p {
            position: absolute;
            top: 200px; /* Abstand vom oberen Rand */
            left: 50%; /* 50% der Bildschirmbreite */
            transform: translateX(-50%); /* Exakte Zentrierung */
        }


        /* LOGO-STYLING (Fixierte Größe) */
        .logo-top, .logo-bottom {
            width: 300px; /* Fixe Größe */
            height: auto; /* Automatische Höhe für korrekte Proportionen */
            position: absolute;
        }

        .logo-bottom {
            bottom: 30%; /* Fixe Position */
        }

        .logo-top {
            opacity: 0;
            animation: logoTopAnimation 3s ease-out forwards;
        }

        /* ANIMATION FÜR DAS OBERE LOGO */
        @keyframes logoTopAnimation {
            0% {
                opacity: 1;
                transform: translateX(110px) translateY(-70px);
            }
            25% {
                opacity: 1 ;
                /*transform-origin: translateX(110px) translateY(-70px);*/
                transform: rotate(180deg);
            }
            50% {
                opacity: 1;
                transform: translateX(300px) translateY(-30px);
            }
            100% {
                opacity: 1;
                transform: translateX(30px) translateY(-95px);
            }
        }

        /* BUTTON */
        .btn-custom {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 50px; 
            font-size: 16px;
        }

        .btn-custom:hover {
            background-color: #218838;
        }
    </style>

</head>
<body>

<div class="container">
    <h1><?php echo $welcomeMessage; ?></h1>
    <p>Das Logo bleibt jetzt fixiert und verändert seine Größe nicht mehr.</p>

    <!-- Logos -->
    <img src="assets/img/LogoTop.png" alt="Logo Top" class="logo-top">
    <img src="assets/img/LogoBottom.png" alt="Logo Bottom" class="logo-bottom">

    <button class="btn-custom">Klick mich!</button>
</div>

</body>
</html>
