<?php
require_once 'src/DbConnexion.php';
require_once 'src/models/DAO/ClientDAO.php';
require_once 'src/models/DAO/VoitureDAO.php';
require_once 'src/models/DAO/OptionDAO.php';
require_once 'src/models/class/Location.php';

class LocationDAO
{
    private static LocationDAO $instance;

    private PDO $connexion;
    private OptionDAO $optionDAO;
    private ClientDAO $clientDAO;
    private VoitureDAO $voitureDAO;
    private ModeleDAO $modeleDAO;

    private function __construct()
    {
        $this->connexion = DbConnexion::getConnexion();
        $this->optionDAO = OptionDAO::getInstance();
        $this->clientDAO = ClientDAO::getInstance();
        $this->voitureDAO = VoitureDAO::getInstance();
        $this->modeleDAO = ModeleDAO::getInstance();
    }

    public static function getInstance(): LocationDAO {
        if(!isset(self::$instance)) {
            self::$instance = new LocationDAO();
        }
        return self::$instance;
    }

    public function getById(int $id): ?Location
    {
        $request = "
            SELECT id_location, date_debut, date_fin, compteur_debut, compteur_fin,
                   id_client, nom, prenom, adresse,
                   id_type_de_client, type_de_client.libelle as libelle_type_de_client,
                   id_voiture, immatriculation, compteur,
                   id_modele, modele.libelle as libelle_modele, image,
                   id_marque, marque.libelle as libelle_marque,
                   id_categorie, categorie.libelle as libelle_categorie, categorie.prix as prix_categorie
            FROM location
            LEFT JOIN client USING(id_client)
            LEFT JOIN type_de_client USING(id_type_de_client)
            LEFT JOIN voiture USING(id_voiture)
            LEFT JOIN modele USING(id_modele)
            LEFT JOIN marque USING(id_marque)
            LEFT JOIN categorie USING(id_categorie)
            WHERE id_location = $id
        ";
        $result = $this->connexion->query($request);
        if($data = $result->fetch()) {
            return $this->dataToLocation($data);
        }
        return null;
    }

    /**
     * @return Location[]
     */
    public function getAll(): array
    {
        $request = "
            SELECT id_location, date_debut, date_fin, compteur_debut, compteur_fin,
                   id_client, nom, prenom, adresse,
                   id_type_de_client, type_de_client.libelle as libelle_type_de_client,
                   id_voiture, immatriculation, compteur,
                   id_modele, modele.libelle as libelle_modele, image,
                   id_marque, marque.libelle as libelle_marque,
                   id_categorie, categorie.libelle as libelle_categorie, categorie.prix as prix_categorie
            FROM location
            LEFT JOIN client USING(id_client)
            LEFT JOIN type_de_client USING(id_type_de_client)
            LEFT JOIN voiture USING(id_voiture)
            LEFT JOIN modele USING(id_modele)
            LEFT JOIN marque USING(id_marque)
            LEFT JOIN categorie USING(id_categorie)
        ";
        $result = $this->connexion->query($request);
        $locations = array();
        while ($data = $result->fetch()) {
            $location = $this->dataToLocation($data);
            array_push($locations, $location);
        }
        return $locations;
    }

    public function update(Location $location): bool {
        try {
            $this->connexion->beginTransaction();

            $request = "DELETE * FROM choix_options WHERE id_location = ?";
            $statement = $this->connexion->prepare($request);
            $statement->execute([$location->getId()]);

            $request = "INSERT INTO choix_options (id_option, id_location) VALUES (?, ?)";
            $statement = $this->connexion->prepare($request);
            foreach ($location->getOptions() as $option) {
                $statement->execute([$option->getId(), $location->getId()]);
            }

            $this->clientDAO->update($location->getClient());
            $this->voitureDAO->update($location->getVoiture());

            $request = "
                UPDATE location
                SET date_debut = ?, date_fin = ?, compteur_debut = ?, compteur_fin = ?, id_client = ?, id_voiture = ?
                WHERE id_location = ?
            ";
            $statement = $this->connexion->prepare($request);
            $statement->execute([
                $location->getDateDebut(),
                $location->getDateFin(),
                $location->getCompteurDebut(),
                $location->getCompteurFin(),
                $location->getClient()->getId(),
                $location->getVoiture()->getId(),
                $location->getId()
            ]);

            $this->connexion->commit();
        } catch (Exception $e) {
            $this->connexion->rollback();
        }
        return true;
    }

    private function dataToLocation($data): Location
    {
        $typeClient = $data['id_type_de_client'] == null ? null : new TypeClient(
            $data['id_type_de_client'],
            $data['libelle_type_de_client']
        );

        $client = $data['id_client'] == null ? null : new Client(
            $data['id_client'],
            $data['nom'],
            $data['prenom'],
            $data['adresse'],
            $typeClient
        );

        $categorie = $data['id_categorie'] == null ? null : new Categorie(
            $data['id_categorie'],
            $data['libelle_categorie'],
            $data['prix_categorie']
        );

        $marque = $data['id_marque'] == null ? null : new Marque(
            $data['id_marque'],
            $data['libelle_marque']
        );

        $modele = $data['id_modele'] == null ? null : new Modele(
            $data['id_modele'],
            $data['libelle_modele'],
            $categorie,
            $marque,
            $data['image']
        );

        $voiture = $data['id_voiture'] == null ? null : new Voiture(
            $data['id_voiture'],
            $data['immatriculation'],
            $data['compteur'],
            $modele
        );

        $options = $this->optionDAO->getAllByLocationId($data['id_location']);

        return new Location(
            $data['id_location'],
            $data['date_debut'],
            $data['date_fin'],
            $data['compteur_debut'],
            $data['compteur_fin'],
            $client,
            $voiture,
            $options
        );
    }

    public function addLocation(string $dateDebut, string $dateFin, int $compteurDebut, int $compteurFin, int $idClient, int $idVoiture, array $idOptions) {
        $request = "
            INSERT INTO location
            (date_debut, date_fin, compteur_debut, compteur_fin, id_client, id_voiture)
            VALUES (?, ?, ?, ?, ?, ?)
        ";
        $statement = $this->connexion->prepare($request);
        $statement->execute([$dateDebut, $dateFin, $compteurDebut, $compteurFin, $idClient, $idVoiture]);

        $idLocation = $this->connexion->lastInsertId();
        foreach ($idOptions as $idOption) {
            $request = "
                INSERT INTO choix_option (id_option, id_location)
                VALUES (?, ?)
            ";
            $statement = $this->connexion->prepare($request);
            $statement->execute([$idOption, $idLocation]);
        }
    }

    public function editLocation(int $idLocation, int $idModele, int $idClient, string $dateDebut,
                                 string $dateFin, int $compteurDebut, int $compteurFin): void
    {
        $voitures = $this->voitureDAO->getAll();
        foreach ($voitures as $voiture) {
            // SI LE MODELE DE LA VOITURE CORRESPOND
            if ($voiture->getModele()->getId() == $idModele) {
                // SI LA VOITURE EST LIBRE
                if ($this->voitureDAO->getDispo($voiture->getId())) {
                    $request = "UPDATE location
                                SET id_client = ?, id_voiture = ?, date_debut = ?, date_fin = ?, compteur_debut = ?, compteur_fin = ?
                                WHERE id_location = ?";
                    $statement = $this->connexion->prepare($request);
                    $statement->execute([$idClient, $voiture->getId(), $dateDebut, $dateFin, $compteurDebut, $compteurFin, $idLocation]);
                    return;
                }
            }
        }

        $request = "UPDATE location SET
        id_client = ?, id_voiture = ?, date_debut = ?, date_fin = ?, compteur_debut = ?, compteur_fin = ?)
        VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $this->connexion->prepare($request);
        $statement->execute([$idModele, $idClient, $dateDebut, $dateFin, $compteurDebut, $compteurFin]);
    }

    public function deleteLocation(int $idLocation): void
    {
        $request = "DELETE FROM choix_option WHERE id_location = $idLocation";
        $statement = $this->connexion->prepare($request);
        $statement->execute();

        $request = "DELETE FROM location WHERE id_location = $idLocation";
        $statement = $this->connexion->prepare($request);
        $statement->execute();
    }

    // A refaire
    public function getNbLocationsByModele(): array
    {
        $locationsByModele = array();
        foreach ($this->modeleDAO->getAll() as $modele) {
            $idModele = $modele->getId();
            $request = "SELECT COUNT(id_modele) AS nbLocation
            FROM location
            JOIN voiture USING(id_voiture)
            JOIN modele USING(id_modele)
            WHERE id_modele = $idModele;";
            $result = $this->connexion->query($request);
            if ($result) {
                while ($data = $result->fetch()) {
                    $nbLocation = $data['nbLocation'];
                    array_push($locationsByModele, $nbLocation);
                }
            } else {
                $nbLocation = 0;
                array_push($locationsByModele, $nbLocation);
            }
        }
        return $locationsByModele;
    }

    public function getCAbyMonth(): array
    {
        $CAbyMonth = array();
        for ($i = 1; $i < 13; $i++) {
            $month = strval($i);
            $nextMonth = strval($i + 1);
            $request = "SELECT SUM(categorie.prix*DATEDIFF(location.date_fin, location.date_debut)) AS totalVente
            FROM location
            JOIN voiture USING(id_voiture)
            JOIN modele USING(id_modele)
            JOIN categorie USING(id_categorie)
            WHERE YEAR(location.date_debut) BETWEEN '2021' AND '2022'
            AND MONTH(location.date_debut) BETWEEN $month AND $nextMonth;";

            $result = $this->connexion->query($request);
            if ($result) {
                while ($data = $result->fetch()) {
                    $nbLocation = $data['totalVente'];
                    array_push($CAbyMonth, $nbLocation);
                }
            } else {
                $nbLocation = 0;
                array_push($CAbyMonth, $nbLocation);
            }
        }
        return $CAbyMonth;
    }
}