<?php

namespace App\Entity\Affaire;

use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Entity\User;
use App\Repository\Affaire\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[Gedmo\Loggable]

class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private $createur;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'datetime')]
    private $dateDeDebut;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'datetime')]
    private $dateDeFin;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $priorite;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $typeDEvenement;

    #[ORM\ManyToMany(targetEntity: Fichier::class, inversedBy: 'evenements')]
    private $fichiers;

    #[ORM\ManyToOne(targetEntity: Demande::class, inversedBy: 'evenements')]
    private $demande;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $statut;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'EvenementsAttribues')]
    private $attribueA;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;


    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
        $this->statut = "En cours";
        $this->priorite = "Normal";
        $this->attribueA = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getDateDeDebut(): ?\datetime
    {
        return $this->dateDeDebut;
    }

    public function setDateDeDebut(\datetime $dateDeDebut): self
    {
        $this->dateDeDebut = $dateDeDebut;

        return $this;
    }

    public function getDateDeFin(): ?\datetime
    {
        return $this->dateDeFin;
    }

    public function setDateDeFin(\datetime $dateDeFin): self
    {
        $this->dateDeFin = $dateDeFin;

        return $this;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(string $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getTypeDEvenement(): ?string
    {
        return $this->typeDEvenement;
    }

    public function setTypeDEvenement(string $typeDEvenement): self
    {
        $this->typeDEvenement = $typeDEvenement;

        return $this;
    }


    /**
     * @return Collection<int, Fichier>
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        $this->fichiers->removeElement($fichier);

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    #[ORM\PreUpdate]
    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAttribueA(): Collection
    {
        return $this->attribueA;
    }

    public function addAttribueA(User $attribueA): self
    {
        if (!$this->attribueA->contains($attribueA)) {
            $this->attribueA[] = $attribueA;
        }

        return $this;
    }

    public function removeAttribueA(User $attribueA): self
    {
        $this->attribueA->removeElement($attribueA);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

}
