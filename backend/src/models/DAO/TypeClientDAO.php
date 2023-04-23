<?php
require_once 'src/DbConnexion.php';
require_once 'src/models/class/TypeClient.php';

class TypeClientDAO
{
    private static TypeClientDAO $instance;

    private PDO $connexion;

    private function __construct()
    {
        $this->connexion = DbConnexion::getConnexion();
    }

    public static function getInstance(): TypeClientDAO {
        if(!isset(self::$instance)) {
            self::$instance = new TypeClientDAO();
        }
        return self::$instance;
    }

    public function getById(int $id): ?TypeClient
    {
        $request = "
            SELECT id_type_de_client, libelle
            FROM type_de_client
            WHERE id_type_de_client = $id
        ";
        $result = $this->connexion->query($request);
        if($data = $result->fetch()) {
            return $this->dataToTypeClient($data);
        }
        return null;
    }

    /**
     * @return TypeClient[]
     */
    public function getAll(): array
    {
        $request = "
            SELECT id_type_de_client, libelle
            FROM type_de_client;
        ";
        $result = $this->connexion->query($request);
        $typesClient = array();
        while ($data = $result->fetch()) {
            $typeClient = $this->dataToTypeClient($data);
            array_push($typesClient, $typeClient);
        }
        return $typesClient;
    }

    /**
     * @param int $clientId
     * @return TypeClient
     */
    public function getByClientId(int $clientId): TypeClient
    {
        $request = "
            SELECT *
            FROM `type_de_client`
            LEFT JOIN client USING(id_client)
            WHERE id_client = $clientId;
        ";
        $result = $this->connexion->query($request);
        $typesClient = array();
        while ($data = $result->fetch()) {
            $typeClient = $this->dataToTypeClient($data);
            array_push($options, $typeClient);
        }
        return $typesClient;
    }

    public function update(TypeClient $typeClient): bool {
        $request = "
            UPDATE type_de_client
            SET libelle = ?
            WHERE id_type_de_client = ?
        ";
        $statement = $this->connexion->prepare($request);
        return $statement->execute([$typeClient->getLibelle(), $typeClient->getId()]);
    }

    private function dataToTypeClient($data): TypeClient
    {
        return new TypeClient(
            $data['id_type_de_client'],
            $data['libelle']
        );
    }
}