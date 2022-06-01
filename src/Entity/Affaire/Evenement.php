<?php

namespace App\Entity\Affaire;

use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Entity\User;
use App\Repository\Affaire\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private $createur;

    #[ORM\Column(type: 'datetime')]
    private $dateDeDebut;

    #[ORM\Column(type: 'datetime', length: 255)]
    private $dateDeFin;

    #[ORM\Column(type: 'string', length: 255)]
    private $priorite;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDEvenement;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'evenementsAttribues')]
    #[ORM\JoinColumn(nullable: false)]
    private $attribueA;

    #[ORM\ManyToMany(targetEntity: Fichier::class, inversedBy: 'evenements')]
    private $fichiers;

    #[ORM\ManyToOne(targetEntity: Demande::class, inversedBy: 'evenements')]
    private $demande;


    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
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

    public function getAttribueA(): ?User
    {
        return $this->attribueA;
    }

    public function setAttribueA(?User $attribueA): self
    {
        $this->attribueA = $attribueA;

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

}
