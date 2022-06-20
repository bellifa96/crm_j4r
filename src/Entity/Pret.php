<?php

namespace App\Entity;

use App\Entity\Ged\Fichier;
use App\Repository\PretRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PretRepository::class)]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $dateDAffectation;

    #[ORM\Column(type: 'string', length: 255)]
    private $dateDeRetour;

    #[ORM\Column(type: 'text')]
    private $etat;

    #[ORM\Column(type: 'text', nullable: true)]
    private $etatApresRetour;

    #[ORM\Column(type: 'text', nullable: true)]
    private $note;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\OneToMany(mappedBy: 'pret', targetEntity: Fichier::class)]
    private $fichiers;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'prets')]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: Materiel::class, inversedBy: 'prets')]
    private $materiel;

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDAffectation(): ?string
    {
        return $this->dateDAffectation;
    }

    public function setDateDAffectation(string $dateDAffectation): self
    {
        $this->dateDAffectation = $dateDAffectation;

        return $this;
    }

    public function getDateDeRetour(): ?string
    {
        return $this->dateDeRetour;
    }

    public function setDateDeRetour(string $dateDeRetour): self
    {
        $this->dateDeRetour = $dateDeRetour;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getEtatApresRetour(): ?string
    {
        return $this->etatApresRetour;
    }

    public function setEtatApresRetour(?string $etatApresRetour): self
    {
        $this->etatApresRetour = $etatApresRetour;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
            $fichier->setPret($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->removelement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getPret() === $this) {
                $fichier->setPret(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }
}
