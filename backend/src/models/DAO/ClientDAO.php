<?php
require_once 'src/DbConnexion.php';
require_once 'src/models/DAO/TypeClientDAO.php';
require_once 'src/models/class/Client.php';
require_once 'src/models/class/TypeClient.php';

class ClientDAO
{
    private static ClientDAO $instance;

    private PDO $connexion;
    private TypeClientDAO $typeClientDAO;

    private function __construct()
    {
        $this->connexion = DbConnexion::getConnexion();
        $this->typeClientDAO = TypeClientDAO::getInstance();
    }

    public static function getInstance(): ClientDAO {
        if(!isset(self::$instance)) {
            self::$instance = new ClientDAO();
        }
        return self::$instance;
    }

    public function getById(int $id): ?Client
    {
        $request = "
            SELECT id_client, nom, prenom, adresse, id_type_de_client, libelle
            FROM client
            LEFT JOIN type_de_client tdc USING(id_type_de_client)
            WHERE id_client = $id
        ";
        $result = $this->connexion->query($request);
        if($data = $result->fetch()) {
            return $this->dataToClient($data);
        }
        return null;
    }

    /**
     * @return Client[]
     */
    public function getAll(): array
    {
        $request = "
            SELECT id_client, nom, prenom, adresse, id_type_de_client, libelle
            FROM client
            LEFT JOIN type_de_client tdc USING(id_type_de_client)
        ";
        $result = $this->connexion->query($request);
        $clients = array();
        while ($data = $result->fetch()) {
            $client = $this->dataToClient($data);
            array_push($clients, $client);
        }
        return $clients;
    }

    public function update(Client $client): bool {
        $this->typeClientDAO->update($client->getTypeClient());

        $request = "
            UPDATE client
            SET nom = ?, prenom = ?, adresse = ?, id_type_de_client = ?
            WHERE id_client = ?
        ";
        $statement = $this->connexion->prepare($request);
        return $statement->execute([$client->getNom(), $client->getPrenom(), $client->getAdresse(), $client->getTypeClient()->getId(), $client->getId()]);
    }

    private function dataToClient($data): Client
    {
        $typeClient = $data['id_type_de_client'] == null ? null : new TypeClient(
            $data['id_type_de_client'],
            $data['libelle']
        );

        return new Client(
            $data['id_client'],
            $data['nom'],
            $data['prenom'],
            $data['adresse'],
            $typeClient
        );
    }

    // Modification de données
    public function addClient(string $nom, string $prenom, string $adresse, int $typeClient): void
    {
        $request = "INSERT INTO client (nom, prenom, adresse, id_type_de_client)
        VALUES (?, ?, ?, ?);";

        $statement = $this->connexion->prepare($request);
        $statement->execute([$nom, $prenom, $adresse, $typeClient]);
    }

    public function editClient(int $idClient, string $nom, string $prenom, string $adresse, $typeClient): void
    {
        $request = "
            UPDATE client
            SET nom = ?, prenom = ?, adresse = ?, id_type_de_client = ?
            WHERE id_client = ?
        ";
        $statement = $this->connexion->prepare($request);
        $statement->execute([$nom, $prenom, $adresse, $typeClient, $idClient]);
    }

    public function deleteClient(int $idClient): void
    {
        $request = "DELETE FROM client
        WHERE id_client = $idClient;";
        $statement = $this->connexion->prepare($request);
        $statement->execute();
    }

    // A refaire
    public function getNbLocationById(int $idClient): int
    {
        $request = "SELECT COUNT(id_location) AS nbLocation 
        FROM location
        WHERE id_client = $idClient;";
        $result = $this->connexion->query($request);
        while ($data = $result->fetch()) {
            return ($data['nbLocation']);
        }
    }
}