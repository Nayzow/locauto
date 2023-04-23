<?php
require_once 'src/views/components/style.php';
require_once 'src/views/components/header.php';

// Switch de la vue principale

if (isset($_GET['choice'])) {
    $view = $_GET['choice'];
    switch ($view) {
        case "voitures":
            require_once('src/views/voitures.php');
            break;
        case "clients":
            require_once('src/views/clients.php');
            break;
        case "locations":
            require_once('src/views/locations.php');
            break;
        case "statistiques":
            require_once('src/views/statistiques.php');
            break;
        case "home":
            require_once('src/views/home.php');
            break;
    }
} else {
    require_once('src/views/home.php');
}

require_once 'src/views/components/footer.php';