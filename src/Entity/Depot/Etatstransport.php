<?php

namespace App\Entity\Depot;

use App\Repository\Depot\EtatTransportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatTransportRepository::class)]
class Etatstransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $id;

    #[ORM\Column(type: 'string')]

    private $numaffaire;

    #[ORM\Column(type: 'integer')]

    private $numbon;

    #[ORM\Column(type: 'string')]

    private $typebon;

    #[ORM\Column(type: 'datetime')]

    private $datebon;

    #[ORM\Column(type: 'string')]

    private $consignes;

    #[ORM\Column(type: 'integer')]

    private $numticket;


    #[ORM\Column(type: 'string')]
    private $arrivee;

    #[ORM\Column(type: 'string')]

    private $heurepesee1;

    #[ORM\Column(type: 'float')]

    private $poidspesee1;

    #[ORM\Column(type: 'integer')]

    private $basculepesee1;

    #[ORM\Column(type: 'string')]

    private $heurepesee2;

    #[ORM\Column(type: 'float')]

    private $poidspesee2;

    #[ORM\Column(type: 'integer')]

    private $basculepesee2;

    #[ORM\Column(type: 'float')]

    private $poidsmesure1;

    #[ORM\Column(type: 'float')]

    private $poidsmesure2;

    #[ORM\Column(type: 'string')]

    private $nomchauffeur;

    #[ORM\Column(type: 'string')]

    private $nomtransporteur;

    #[ORM\Column(type: 'string')]

    private $immatriculation;

    #[ORM\Column(type: 'string')]

    private $depart;

    #[ORM\Column(type: 'string')]

    private $dateboninv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumAffaire(): ?string
    {
        return $this->numaffaire;
    }

    public function setNumAffaire(string $numaffaire): self
    {
        $this->numaffaire = $numaffaire;
        return $this;
    }

    public function getNumBon(): ?int
    {
        return $this->numbon;
    }

    public function setNumBon(int $numbon): self
    {
        $this->numbon = $numbon;
        return $this;
    }

    public function getTypeBon(): ?string
    {
        return $this->typebon;
    }

    public function setTypeBon(string $typebon): self
    {
        $this->typebon = $typebon;
        return $this;
    }

    public function getDateBon(): ?\DateTimeInterface
    {
        return $this->datebon;
    }

    public function setDateBon(\DateTimeInterface $datebon): self
    {
        $this->datebon = $datebon;
        return $this;
    }

    public function getConsignes(): ?string
    {
        return $this->consignes;
    }

    public function setConsignes(string $consignes): self
    {
        $this->consignes = $consignes;
        return $this;
    }

    public function getNumTicket(): ?int
    {
        return $this->numticket;
    }

    public function setNumTicket(int $numticket): self
    {
        $this->numticket = $numticket;
        return $this;
    }

    public function getArrivee(): ?string
    {
        return $this->arrivee;
    }

    public function setArrivee(string $arrivee): self
    {
        $this->arrivee = $arrivee;
        return $this;
    }

    public function getHeurePesee1(): ?string
    {
        return $this->heurepesee1;
    }

    public function setHeurePesee1(string $heurepesee1): self
    {
        $this->heurepesee1 = $heurepesee1;
        return $this;
    }

    public function getPoidsPesee1(): ?float
    {
        return $this->poidspesee1;
    }

    public function setPoidsPesee1(float $poidspesee1): self
    {
        $this->poidspesee1 = $poidspesee1;
        return $this;
    }

    public function getBasculePesee1(): ?int
    {
        return $this->basculepesee1;
    }

    public function setBasculePesee1(int $basculepesee1): self
    {
        $this->basculepesee1 = $basculepesee1;
        return $this;
    }

    public function getHeurePesee2(): ?string
    {
        return $this->heurepesee2;
    }

    public function setHeurePesee2(string $heurepesee2): self
    {
        $this->heurepesee2 = $heurepesee2;
        return $this;
    }

    public function getPoidsPesee2(): ?float
    {
        return $this->poidspesee2;
    }

    public function setPoidsPesee2(float $poidspesee2): self
    {
        $this->poidspesee2 = $poidspesee2;
        return $this;
    }

    public function getBasculePesee2(): ?int
    {
        return $this->basculepesee2;
    }

    public function setBasculePesee2(int $basculepesee2): self
    {
        $this->basculepesee2 = $basculepesee2;
        return $this;
    }

    public function getPoidsMesure1(): ?float
    {
        return $this->poidsmesure1;
    }

    public function setPoidsMesure1(float $poidsmesure1): self
    {
        $this->poidsmesure1 = $poidsmesure1;
        return $this;
    }

    public function getPoidsMesure2(): ?float
    {
        return $this->poidsmesure2;
    }

    public function setPoidsMesure2(float $poidsmesure2): self
    {
        $this->poidsmesure2 = $poidsmesure2;
        return $this;
    }

    public function getNomChauffeur(): ?string
    {
        return $this->nomchauffeur;
    }

    public function setNomChauffeur(string $nomchauffeur): self
    {
        $this->nomchauffeur = $nomchauffeur;
        return $this;
    }

    public function getNomTransporteur(): ?string
    {
        return $this->nomtransporteur;
    }

    public function setNomTransporteur(string $nomtransporteur): self
    {
        $this->nomtransporteur = $nomtransporteur;
        return $this;
    }
    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;
        return $this;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;
        return $this;
    }

    public function getDateBonInv(): ?string
    {
        return $this->dateboninv;
    }

    public function setDateBonInv(string $dateboninv): self
    {
        $this->dateboninv = $dateboninv;
        return $this;
    }
}
