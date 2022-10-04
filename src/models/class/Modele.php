<?php
require_once 'src/models/class/Categorie.php';
require_once 'src/models/class/Marque.php';

class Modele
{
    private ?int $id;
    private ?string $libelle;
    private ?Categorie $categorie;
    private ?Marque $marque;
    private ?string $image;

    public function __construct($id, $libelle, $categorie, $marque, $image)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->categorie = $categorie;
        $this->marque = $marque;
        $this->image = $image;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    public function getMarque(): Marque
    {
        return $this->marque;
    }

    public function __toString(): string
    {
        return serialize($this);
    }
}