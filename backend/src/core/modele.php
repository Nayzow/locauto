<?php

require_once 'src/models/DAO/VoitureDAO.php';
require_once 'src/models/DAO/ModeleDAO.php';
require_once 'src/models/DAO/CategorieDAO.php';
require_once 'src/models/DAO/MarqueDAO.php';
require_once 'src/models/DAO/ClientDAO.php';
require_once 'src/models/DAO/TypeClientDAO.php';
require_once 'src/models/DAO/LocationDAO.php';
require_once 'src/models/DAO/OptionDAO.php';

// Voitures
$voitureDAO = VoitureDAO::getInstance();
$modeleDAO = ModeleDAO::getInstance();
$categorieDAO = CategorieDAO::getInstance();
$marqueDAO = MarqueDAO::getInstance();

// Clients
$clientDAO = ClientDAO::getInstance();
$typeClientDAO = TypeClientDAO::getInstance();

// Locations
$locationDAO = LocationDAO::getInstance();
$optionDAO = OptionDAO::getInstance();