<?php

class Categorie
{
    private ?string $id;
    private ?string $libelle;
    private ?int $prix;

    public function __construct(string $id, string $libelle, int $prix)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->prix = $prix;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getPrix(): int
    {
        return $this->prix;
    }

    public function __toString(): string
    {
        return serialize($this);
    }
}