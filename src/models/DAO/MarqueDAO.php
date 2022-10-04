<?php
require_once 'src/DbConnexion.php';
require_once 'src/models/class/Marque.php';

class MarqueDAO
{
    private static MarqueDAO $instance;

    private PDO $connexion;

    private function __construct()
    {
        $this->connexion = DbConnexion::getConnexion();
    }

    public static function getInstance(): MarqueDAO {
        if(!isset(self::$instance)) {
            self::$instance = new MarqueDAO();
        }
        return self::$instance;
    }

    public function getById(int $id): ?Marque
    {
        $request = "
            SELECT id_marque, libelle
            FROM marque
            WHERE id_marque = $id
        ";
        $result = $this->connexion->query($request);
        if($data = $result->fetch()) {
            return $this->dataToMarque($data);
        }
        return null;
    }

    /**
     * @return Marque[]
     */
    public function getAll(): array
    {
        $request = "
            SELECT id_marque, libelle
            FROM marque
        ";
        $result = $this->connexion->query($request);
        $marques = array();
        while ($data = $result->fetch()) {
            $marque = $this->dataToMarque($data);
            array_push($marques, $marque);
        }
        return $marques;
    }

    public function update(Marque $marque): bool {
        $request = "
            UPDATE marque
            SET libelle = ?
            WHERE id_marque = ?
        ";
        $statement = $this->connexion->prepare($request);
        return $statement->execute([$marque->getLibelle(), $marque->getId()]);
    }

    private function dataToMarque($data): Marque
    {
        return new Marque(
            $data['id_marque'],
            $data['libelle']
        );
    }
}