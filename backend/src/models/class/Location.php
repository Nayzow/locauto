<?php
require_once 'src/models/class/Client.php';
require_once 'src/models/class/Voiture.php';
require_once 'src/models/class/Option.php';

class Location
{
    private ?int $id;
    private ?string $dateDebut;
    private ?string $dateFin;
    private ?int $compteurDebut;
    private ?int $compteurFin;
    private ?Client $client;
    private ?Voiture $voiture;

    /**
     * @var Option[]
     */
    private array $options;

    public function __construct(int $id, string $dateDebut, string $dateFin, int $compteurDebut, int $compteurFin, Client $client, Voiture $voiture, array $options)
    {
        $this->id = $id;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->compteurDebut = $compteurDebut;
        $this->compteurFin = $compteurFin;
        $this->client = $client;
        $this->voiture = $voiture;
        $this->options = $options;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }

    public function getDateFin(): string
    {
        return $this->dateFin;
    }

    public function getCompteurDebut(): int
    {
        return $this->compteurDebut;
    }

    public function getCompteurFin(): int
    {
        return $this->compteurFin;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getVoiture(): Voiture
    {
        return $this->voiture;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getPrixAllOptions(): int
    {
        $prixAllOptions = 0;
        foreach ($this->getOptions() as $option) {
            $prixAllOptions += $option->getPrix();
        }
        return $prixAllOptions;
    }

    public function getKm(): int
    {
        return $this->getCompteurFin() - $this->getCompteurDebut();
    }

    public function getPrixLocation(): int
    {
        return $this->getVoiture()->getModele()->getCategorie()->getPrix() * $this->getDuree() + $this->getPrixAllOptions();
    }

    public function getDuree(): int
    {
        $debut = date_create($this->getDateDebut());
        $fin = date_create($this->getDateFin());
        $duree = date_diff($fin, $debut);
        return $duree->format('%a');
    }

    public function getDispo(): string
    {
        $dateDebut = date_create($this->getDateDebut());
        $dateFin = date_create($this->getDateFin());
        $dateDuJour = date_create(date("Y-m-d", strtotime("now")));

        if ($dateDebut < $dateDuJour && $dateDuJour < $dateFin) {
            return "Oui";
        } else {
            return "Non";
        }
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setDateDebut(string $dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    public function setDateFin(string $dateFin)
    {
        $this->dateFin = $dateFin;
    }

    public function setCompteurDebut(int $compteurDebut)
    {
        $this->compteurDebut = $compteurDebut;
    }

    public function setCompteurFin(int $compteurFin)
    {
        $this->compteurFin = $compteurFin;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function setVoiture(Voiture $voiture)
    {
        $this->voiture = $voiture;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function __toString(): string
    {
        return serialize($this);
    }
}