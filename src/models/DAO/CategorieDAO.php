<?php
require_once 'src/DbConnexion.php';
require_once 'src/models/class/Categorie.php';

class CategorieDAO
{
    private static CategorieDAO $instance;

    private PDO $connexion;

    private function __construct()
    {
        $this->connexion = DbConnexion::getConnexion();
    }

    public static function getInstance(): CategorieDAO {
        if(!isset(self::$instance)) {
            self::$instance = new CategorieDAO();
        }
        return self::$instance;
    }

    public function getById(int $id): ?Categorie
    {
        $request = "
            SELECT id_categorie, libelle, prix
            FROM categorie
            WHERE id_categorie = '$id'
        ";
        $result = $this->connexion->query($request);
        if($data = $result->fetch()) {
            return $this->dataToCategorie($data);
        }
        return null;
    }

    /**
     * @return Categorie[]
     */
    public function getAll(): array
    {
        $request = "
            SELECT id_categorie, libelle, prix
            FROM categorie
        ";
        $result = $this->connexion->query($request);
        $categories = array();
        while ($data = $result->fetch()) {
            $categorie = $this->dataToCategorie($data);
            array_push($categories, $categorie);
        }
        return $categories;
    }

    public function update(Categorie $categorie): bool {
        $request = "
            UPDATE categorie
            SET libelle = ?, prix = ?
            WHERE id_categorie = ?
        ";
        $statement = $this->connexion->prepare($request);
        return $statement->execute([$categorie->getLibelle(), $categorie->getPrix(), $categorie->getId()]);
    }

    private function dataToCategorie($data): Categorie
    {
        return new Categorie(
            $data['id_categorie'],
            $data['libelle'],
            $data['prix']
        );
    }
}