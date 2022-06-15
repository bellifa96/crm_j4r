<?php

namespace App\Entity\Ged;

use App\Entity\Affaire\Evenement;
use App\Entity\Demande;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\TimesTrait;
use App\Entity\User;
use App\Repository\Ged\FichierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichierRepository::class)]
class Fichier
{

    use TimesTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $fichier;

    #[ORM\Column(type: 'boolean')]
    private $isDeleted;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'fichiers')]
    private $createur;

    #[ORM\ManyToOne(targetEntity: TypeFichier::class, inversedBy: 'fichiers')]
    #[ORM\JoinColumn(nullable: false)]
    private $typeFichier;

    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'fichiers')]
    private $evenements;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'fichiers')]
    private $interlocuteur;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $supprimePar;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $restaurePar;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $supprimeLe;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $restaurerLe;

    #[ORM\ManyToOne(targetEntity: Demande::class, inversedBy: 'ged')]
    private $demande;

    public function __construct(){
        $this->isDeleted = false;
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

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

    public function getTypeFichier(): ?TypeFichier
    {
        return $this->typeFichier;
    }

    public function setTypeFichier(?TypeFichier $typeFichier): self
    {
        $this->typeFichier = $typeFichier;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->addFichier($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            $evenement->removeFichier($this);
        }

        return $this;
    }

    public function getInterlocuteur(): ?Interlocuteur
    {
        return $this->interlocuteur;
    }

    public function setInterlocuteur(?Interlocuteur $interlocuteur): self
    {
        $this->interlocuteur = $interlocuteur;

        return $this;
    }

    public function getSupprimePar(): ?User
    {
        return $this->supprimePar;
    }

    public function setSupprimePar(?User $supprimePar): self
    {
        $this->supprimePar = $supprimePar;

        return $this;
    }

    public function getRestaurePar(): ?User
    {
        return $this->restaurePar;
    }

    public function setRestaurePar(?User $restaurePar): self
    {
        $this->restaurePar = $restaurePar;

        return $this;
    }

    public function getSupprimeLe(): ?\DateTimeInterface
    {
        return $this->supprimeLe;
    }

    public function setSupprimeLe(?\DateTimeInterface $supprimeLe): self
    {
        $this->supprimeLe = $supprimeLe;

        return $this;
    }

    public function getRestaurerLe(): ?\DateTimeInterface
    {
        return $this->restaurerLe;
    }

    public function setRestaurerLe(?\DateTimeInterface $restaurerLe): self
    {
        $this->restaurerLe = $restaurerLe;

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
