<?php
require_once 'src/models/class/Modele.php';

class Voiture
{
    private ?int $id;
    private ?string $immatriculation;
    private ?int $compteur;
    private ?Modele $modele;

    public function __construct(int $id, string $immatriculation, int $compteur, Modele $modele)
    {
        $this->id = $id;
        $this->immatriculation = $immatriculation;
        $this->compteur = $compteur;
        $this->modele = $modele;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getImmatriculation(): string
    {
        return $this->immatriculation;
    }

    public function getCompteur(): int
    {
        return $this->compteur;
    }

    public function getModele(): Modele
    {
        return $this->modele;
    }

    public function __toString(): string
    {
        return serialize($this);
    }
}