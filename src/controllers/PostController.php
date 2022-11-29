<?php
$error = "";

if (isset($_POST['addClient'])) {
    $clientDAO->addClient($_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['typeClient']);
}

if (isset($_POST['editClient'])) {
    $clientDAO->editClient($_POST["idClient"], $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['typeClient']);
}

if (isset($_POST['deleteClient'])) {
    $locations = $locationDAO->getAll();

    foreach ($locations as $location) {
        if($location->getClient()->getId() == $_POST['idClient']) {
            $error = "Ce client a actuellement une location en cours.";
            return;
        }
    }

    $clientDAO->deleteClient($_POST['idClient']);
}

if (isset($_POST['addVoiture'])) {
    $voitureDAO->addVoiture($_POST['idModele'], $_POST['immatriculation'], $_POST['compteur']);
}

if (isset($_POST['editVoiture'])) {
    $voitureDAO->editVoiture($_POST['idVoiture'], $_POST['immatriculation'], $_POST['compteur'], $_POST['idModele']);
}

if (isset($_POST['deleteVoiture'])) {
    $locations = $locationDAO->getAll();

    foreach ($locations as $location) {
        if($location->getVoiture()->getId() == $_POST['idVoiture']) {
            $error = "Cette voiture a actuellement une location en cours.";
            return;
        }
    }

    $voitureDAO->deleteVoiture($_POST['idVoiture']);
}

if (isset($_POST['addLocation'])) {
    $voiture = $voitureDAO->getOneDispoByIdModele($_POST['idModele'], $_POST['dateDebut'], $_POST['dateFin']);

    if(is_null($voiture)) {
        $error = "Impossible de louer ce modèle sur ce crénaux.";
        return;
    }

    $locationDAO->addLocation(
        $_POST['dateDebut'],
        $_POST['dateFin'],
        $_POST['compteurDebut'],
        $_POST['compteurFin'],
        $_POST['idClient'],
        $voiture->getId(),
        $_POST['options']
    );
}

if (isset($_POST['editLocation'])) {
    // RECHERCHE UNE VOITURE DISPO
    $voiture = $voitureDAO->getOneDispoByIdModele($_POST['idModele'], $_POST['dateDebut'], $_POST['dateFin']);

    if(is_null($voiture)) {
        $error = "Impossible de louer ce modèle sur ce crénaux.";
        return;
    }

    // CREER LES OPTIONS VIA LEUR ID
    $options = array();
    foreach ($_POST['options'] as $optionId) {
        $option = $optionDAO->getById(intval($optionId));
        if(!is_null($option)) {
            array_push($options, $option);
        }
    }

    $client = $clientDAO->getById($_POST['idClient']);

    $location = $locationDAO->getById(intval($_POST['idLocation']));
    $location->setDateDebut($_POST['dateDebut']);
    $location->setDateFin($_POST['dateFin']);
    $location->setCompteurDebut(intval($_POST['compteurDebut']));
    $location->setCompteurFin(intval($_POST['compteurFin']));
    $location->setClient($client);
    $location->setVoiture($voiture);
    $location->setOptions($options);
    $locationDAO->update($location);
}

if (isset($_POST['deleteLocation'])) {
    $locationDAO->deleteLocation($_POST['idLocation']);
}
