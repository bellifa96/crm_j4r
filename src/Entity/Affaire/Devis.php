<?php

namespace App\Entity\Affaire;

use App\Entity\Demande;
use App\Entity\TimesTrait;
use App\Entity\User;
use App\Repository\Affaire\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
#[Gedmo\Loggable]
class Devis
{

    use TimesTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Demande::class, inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    private $demande;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $numero;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $dateDuDevis;

    #[ORM\Column(type: 'string', length: 255)]
    private $statut;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'devis')]
    private $referent;

    #[ORM\OneToMany(mappedBy: 'devis', targetEntity: Lot::class)]
    private $lots;

    public function __construct(){
        $this->dateDuDevis = date('d/m/Y');
        $this->lots = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
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

    public function getDateDuDevis(): ?string
    {
        return $this->dateDuDevis;
    }

    public function setDateDuDevis(string $dateDuDevis): self
    {
        $this->dateDuDevis = $dateDuDevis;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getReferent(): ?User
    {
        return $this->referent;
    }

    public function setReferent(?User $referent): self
    {
        $this->referent = $referent;

        return $this;
    }

    /**
     * @return Collection<int, Lot>
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): self
    {
        if (!$this->lots->contains($lot)) {
            $this->lots[] = $lot;
            $lot->setDevis($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): self
    {
        if ($this->lots->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getDevis() === $this) {
                $lot->setDevis(null);
            }
        }

        return $this;
    }

}
