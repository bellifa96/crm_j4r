<?php

namespace App\Entity\Depot;

use App\Repository\Depot\EtatEnCoursRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: EtatEnCoursRepository::class)]
class Etatsencours
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $numaffaire;

    #[ORM\Column(type: 'string')]
    private $nom;

    #[ORM\Column(type: 'string')]
    private $adresse1;

    #[ORM\Column(type: 'string')]
    private $adresse2;

    #[ORM\Column(type: 'string')]
    private $adresse3;

    #[ORM\Column(type: 'string')]

    private $codepostal;
    #[ORM\Column(type: 'string')]
    private $ville;

    #[ORM\Column(type: 'string')]
    private $datedebutinv;

    #[ORM\Column(type: 'string')]
    private $datefininv;

    #[ORM\Column(type: 'boolean')]
    private $actif = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNumAffaire(): ?string
    {
        return $this->numaffaire;
    }

    public function setNumAffaire(?string $numaffaire): void
    {
        $this->numaffaire = $numaffaire;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(?string $adresse1): void
    {
        $this->adresse1 = $adresse1;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): void
    {
        $this->adresse2 = $adresse2;
    }

    public function getAdresse3(): ?string
    {
        return $this->adresse3;
    }

    public function setAdresse3(?string $adresse3): void
    {
        $this->adresse3 = $adresse3;
    }

    public function getCodePostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodePostal(?string $codepostal): void
    {
        $this->codepostal = $codepostal;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): void
    {
        $this->ville = $ville;
    }

    public function getDateDebutInv(): ?string
    {
        return $this->datedebutinv;
    }

    public function setDateDebutInv(?string $datedebutinv): void
    {
        $this->datedebutinv = $datedebutinv;
    }

    public function getDateFinInv(): ?string
    {
        return $this->datefininv;
    }

    public function setDateFinInv(?string $datefininv): void
    {
        $this->datefininv = $datefininv;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
    }
}
