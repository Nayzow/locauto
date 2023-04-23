<?php
require_once 'src/DbConnexion.php';
require_once 'src/models/DAO/ModeleDAO.php';
require_once 'src/models/DAO/LocationDAO.php';
require_once 'src/models/class/Voiture.php';
require_once 'src/models/class/Categorie.php';
require_once 'src/models/class/Marque.php';
require_once 'src/models/class/Modele.php';

class VoitureDAO
{
    private static VoitureDAO $instance;

    private PDO $connexion;
    private ModeleDAO $modeleDAO;

    private function __construct()
    {
        $this->connexion = DbConnexion::getConnexion();
        $this->modeleDAO = ModeleDAO::getInstance();
    }

    public static function getInstance(): VoitureDAO {
        if(!isset(self::$instance)) {
            self::$instance = new VoitureDAO();
        }
        return self::$instance;
    }

    public function getById(int $id): ?Voiture
    {
        $request = "
            SELECT id_voiture, immatriculation, compteur,
            id_modele, modele.libelle as libelle_modele, image,
            id_marque, marque.libelle as libelle_marque, id_categorie, categorie.libelle as libelle_categorie, prix
            FROM voiture
            LEFT JOIN modele USING(id_modele)
            LEFT JOIN marque USING(id_marque)
            LEFT JOIN categorie USING(id_categorie)
            WHERE id_voiture = $id
        ";
        $result = $this->connexion->query($request);
        if($data = $result->fetch()) {
            return $this->dataToVoiture($data);
        }
        return null;
    }

    /**
     * @return Voiture[]
     */
    public function getAll(): array
    {
        $request = "
            SELECT id_voiture, immatriculation, compteur,
            id_modele, modele.libelle as libelle_modele, image,
            id_marque, marque.libelle as libelle_marque, id_categorie, categorie.libelle as libelle_categorie, prix
            FROM voiture
            LEFT JOIN modele USING(id_modele)
            LEFT JOIN marque USING(id_marque)
            LEFT JOIN categorie USING(id_categorie)
        ";
        $result = $this->connexion->query($request);
        $voitures = array();
        while ($data = $result->fetch()) {
            $voiture = $this->dataToVoiture($data);
            array_push($voitures, $voiture);
        }
        return $voitures;
    }

    public function getOneDispoByIdModele(int $idModele, string $dateDebut, string $dateFin): ?Voiture
    {
        $request = "
        SELECT id_voiture, immatriculation, compteur,
        id_modele, modele.libelle as libelle_modele, image,
        id_marque, marque.libelle as libelle_marque, id_categorie, categorie.libelle as libelle_categorie, prix
        FROM voiture
        LEFT JOIN modele USING(id_modele)
        LEFT JOIN marque USING(id_marque)
        LEFT JOIN categorie USING(id_categorie)
        WHERE id_modele = " . $idModele;
        $result = $this->connexion->query($request);
        $locations = LocationDAO::getInstance()->getAll();
        while ($data = $result->fetch()) {
            $disponible = true;
            $voiture = $this->dataToVoiture($data);
            foreach ($locations as $location) {
                if($location->getVoiture()->getId() == $voiture->getId()) {
                    $debut = date_create($dateDebut);
                    $fin = date_create($dateFin);
                    $tmpDebut = date_create($location->getDateDebut());
                    $tmpFin = date_create($location->getDateFin());
                    if(!($fin < $tmpDebut || $debut > $tmpFin)) {
                        $disponible = false;
                    }
                }
            }
            if($disponible) {
                return $voiture;
            }
        }
        return null;
    }

    public function getDispo(int $idCar): bool
    {
        $request = "SELECT date_debut AS dateDebut, date_fin AS dateFin
        FROM location
        WHERE id_voiture = $idCar";
        $result = $this->connexion->query($request);
        while ($data = $result->fetch()) {
            $dateDebut = date_create($data['dateDebut']);
            $dateFin = date_create($data['dateFin']);
            $dateDuJour = date_create(date("Y-m-d", strtotime("now")));
            if ($dateDebut < $dateDuJour && $dateDuJour < $dateFin) {
                return false;
            }
        }
        return true;
    }

    public function update(Voiture $voiture): bool {
        $this->modeleDAO->update($voiture->getModele());

        $request = "
            UPDATE voiture
            SET immatriculation = ?, compteur = ?, id_modele = ?
            WHERE id_voiture = ?
        ";
        $statement = $this->connexion->prepare($request);
        return $statement->execute([
            $voiture->getImmatriculation(),
            $voiture->getCompteur(),
            $voiture->getModele()->getId(),
            $voiture->getId()
        ]);
    }

    private function dataToVoiture($data): Voiture
    {
        $categorie = $data['id_categorie'] == null ? null : new Categorie(
            $data['id_categorie'],
            $data['libelle_categorie'],
            $data['prix']
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

        return new Voiture(
            $data['id_voiture'],
            $data['immatriculation'],
            $data['compteur'],
            $modele
        );
    }

    // Modifications de données
    public function addVoiture(int $idModele, string $immatriculation, int $compteur): void
    {
        $request = 'INSERT INTO voiture (immatriculation, compteur, id_modele)
        VALUES (?, ?, ?)';
        $statement = $this->connexion->prepare($request);
        $statement->execute([$immatriculation, $compteur, $idModele]);
    }

    public function deleteVoiture(int $idVoiture): void
    {
        $request = "DELETE FROM voiture WHERE id_voiture = $idVoiture";
        $statement = $this->connexion->prepare($request);
        $statement->execute();
    }

    public function editVoiture($idVoiture, $immatriculation, $compteur, $idModele)
    {
        $request = "
            UPDATE voiture
            SET immatriculation = ?, compteur = ?, id_modele = ?
            WHERE id_voiture = ?
        ";
        $statement = $this->connexion->prepare($request);
        $statement->execute([$immatriculation, $compteur, $idModele, $idVoiture]);
    }
}