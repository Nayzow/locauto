<?php
require_once 'src/DbConnexion.php';
require_once 'src/models/DAO/MarqueDAO.php';
require_once 'src/models/DAO/CategorieDAO.php';
require_once 'src/models/class/Modele.php';
require_once 'src/models/class/Categorie.php';
require_once 'src/models/class/Marque.php';

class ModeleDAO
{
    private static ModeleDAO $instance;

    private PDO $connexion;
    private MarqueDAO $marqueDAO;
    private CategorieDAO $categorieDAO;

    private function __construct()
    {
        $this->connexion = DbConnexion::getConnexion();
        $this->marqueDAO = MarqueDAO::getInstance();
        $this->categorieDAO = CategorieDAO::getInstance();
    }

    public static function getInstance(): ModeleDAO
    {
        if (!isset(self::$instance)) {
            self::$instance = new ModeleDAO();
        }
        return self::$instance;
    }

    public function getById(int $id): ?Modele
    {
        $request = "
            SELECT id_modele, modele.libelle as libelle_modele, image,
                   id_categorie, categorie.libelle as libelle_categorie, prix,
                   id_marque, marque.libelle as libelle_marque
            FROM modele
            LEFT JOIN categorie USING(id_categorie)
            LEFT JOIN marque USING(id_marque)
            WHERE id_modele = $id
        ";
        $result = $this->connexion->query($request);
        if ($data = $result->fetch()) {
            return $this->dataToModele($data);
        }
        return null;
    }

    /**
     * @return Modele[]
     */
    public function getAll(): array
    {
        $request = "
            SELECT id_modele, modele.libelle as libelle_modele, image,
                   id_categorie, categorie.libelle as libelle_categorie, prix,
                   id_marque, marque.libelle as libelle_marque
            FROM modele
            LEFT JOIN categorie USING(id_categorie)
            LEFT JOIN marque USING(id_marque)
        ";
        $result = $this->connexion->query($request);
        $modeles = array();
        while ($data = $result->fetch()) {
            $modele = $this->dataToModele($data);
            array_push($modeles, $modele);
        }
        return $modeles;
    }

    public function getAllModeleLibelle(): array
    {
        $allLibelle = array();
        foreach ($this->getAll() as $modele) {
            array_push($allLibelle, $modele->getLibelle());
        }
        return $allLibelle;
    }

    public function update(Modele $modele): bool
    {
        $this->marqueDAO->update($modele->getMarque());
        $this->categorieDAO->update($modele->getCategorie());

        $request = "
            UPDATE modele
            SET libelle = ?, id_categorie = ?, id_marque = ?, image = ?
            WHERE id_modele = ?
        ";
        $statement = $this->connexion->prepare($request);
        return $statement->execute([
            $modele->getLibelle(),
            $modele->getCategorie()->getId(),
            $modele->getMarque()->getId(),
            $modele->getImage(),
            $modele->getId()
        ]);
    }

    private function dataToModele($data): Modele
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

        return new Modele(
            $data['id_modele'],
            $data['libelle_modele'],
            $categorie,
            $marque,
            $data['image']
        );
    }
}