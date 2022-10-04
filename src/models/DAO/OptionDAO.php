<?php
require_once 'src/DbConnexion.php';
require_once 'src/models/class/Option.php';

class OptionDAO
{
    private static OptionDAO $instance;

    private PDO $connexion;

    private function __construct()
    {
        $this->connexion = DbConnexion::getConnexion();
    }

    public static function getInstance(): OptionDAO {
        if(!isset(self::$instance)) {
            self::$instance = new OptionDAO();
        }
        return self::$instance;
    }

    public function getById(int $id): ?Option
    {
        $request = "
            SELECT id_option, libelle, prix
            FROM option
            WHERE id_option = $id
        ";
        $result = $this->connexion->query($request);
        if($data = $result->fetch()) {
            return $this->dataToOption($data);
        }
        return null;
    }

    /**
     * @return Option[]
     */
    public function getAll(): array
    {
        $request = "
            SELECT id_option, libelle, prix
            FROM option
        ";
        $result = $this->connexion->query($request);
        $options = array();
        while ($data = $result->fetch()) {
            $option = $this->dataToOption($data);
            array_push($options, $option);
        }
        return $options;
    }

    /**
     * @param int $locationId
     * @return Option[]
     */
    public function getAllByLocationId(int $locationId): array
    {
        $request = "
            SELECT *
            FROM `option`
            LEFT JOIN choix_option co USING(id_option)
            WHERE id_location = $locationId;
        ";
        $result = $this->connexion->query($request);
        $options = array();
        while ($data = $result->fetch()) {
            $option = $this->dataToOption($data);
            array_push($options, $option);
        }
        return $options;
    }

    private function dataToOption($data): Option
    {
        return new Option(
            $data['id_option'],
            $data['libelle'],
            $data['prix']
        );
    }
}