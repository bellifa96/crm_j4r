<?php

namespace App\Entity;

use App\Entity\Interlocuteur\Interlocuteur;
use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    use AdresseTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'demandes')]
    private $client;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'demandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $createur;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomChantier;

    #[ORM\Column(type: 'string', length: 255)]
    private $date;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'demandes')]
    private $intermediaire;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDePrestation;

    #[ORM\Column(type: 'string', length: 255)]
    private $documentsSouhaites;

    #[ORM\Column(type: 'boolean')]
    private $fondsDePlan;

    #[ORM\Column(type: 'string', length: 255)]
    private $travauxPrevus;

    #[ORM\Column(type: 'string', length: 255)]
    private $classeDEchaffaudage;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDeMateriel;

    #[ORM\Column(type: 'float')]
    private $dimensionsGlobales;

    #[ORM\Column(type: 'string', length: 255)]
    private $ammarages;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Interlocuteur
    {
        return $this->client;
    }

    public function setClient(?Interlocuteur $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNomChantier(): ?string
    {
        return $this->nomChantier;
    }

    public function setNomChantier(string $nomChantier): self
    {
        $this->nomChantier = $nomChantier;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIntermediaire(): ?Interlocuteur
    {
        return $this->intermediaire;
    }

    public function setIntermediaire(?Interlocuteur $intermediaire): self
    {
        $this->intermediaire = $intermediaire;

        return $this;
    }

    public function getTypeDePrestation(): ?string
    {
        return $this->typeDePrestation;
    }

    public function setTypeDePrestation(string $typeDePrestation): self
    {
        $this->typeDePrestation = $typeDePrestation;

        return $this;
    }

    public function getDocumentsSouhaites(): ?string
    {
        return $this->documentsSouhaites;
    }

    public function setDocumentsSouhaites(string $documentsSouhaites): self
    {
        $this->documentsSouhaites = $documentsSouhaites;

        return $this;
    }

    public function getFondsDePlan(): ?bool
    {
        return $this->fondsDePlan;
    }

    public function setFondsDePlan(bool $fondsDePlan): self
    {
        $this->fondsDePlan = $fondsDePlan;

        return $this;
    }

    public function getTravauxPrevus(): ?string
    {
        return $this->travauxPrevus;
    }

    public function setTravauxPrevus(string $travauxPrevus): self
    {
        $this->travauxPrevus = $travauxPrevus;

        return $this;
    }

    public function getClasseDEchaffaudage(): ?string
    {
        return $this->classeDEchaffaudage;
    }

    public function setClasseDEchaffaudage(string $classeDEchaffaudage): self
    {
        $this->classeDEchaffaudage = $classeDEchaffaudage;

        return $this;
    }

    public function getTypeDeMateriel(): ?string
    {
        return $this->typeDeMateriel;
    }

    public function setTypeDeMateriel(string $typeDeMateriel): self
    {
        $this->typeDeMateriel = $typeDeMateriel;

        return $this;
    }

    public function getDimensionsGlobales(): ?float
    {
        return $this->dimensionsGlobales;
    }

    public function setDimensionsGlobales(float $dimensionsGlobales): self
    {
        $this->dimensionsGlobales = $dimensionsGlobales;

        return $this;
    }

    public function getAmmarages(): ?string
    {
        return $this->ammarages;
    }

    public function setAmmarages(string $ammarages): self
    {
        $this->ammarages = $ammarages;

        return $this;
    }
}
