<?php
require_once 'src/models/class/TypeClient.php';

class Client
{
    private ?int $id;
    private ?string $nom;
    private ?string $prenom;
    private ?string $adresse;
    private ?TypeClient $typeClient;

    public function __construct(int $id, string $nom, string $prenom, string $adresse, TypeClient $typeClient)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->typeClient = $typeClient;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function getTypeClient(): TypeClient
    {
        return $this->typeClient;
    }

    public function __toString(): string
    {
        return serialize($this);
    }
}