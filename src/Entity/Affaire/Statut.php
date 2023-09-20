<?php

namespace App\Entity\Affaire;

use App\Entity\Demande;
use App\Repository\Affaire\StatutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutRepository::class)]
class Statut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $couleur;

    #[ORM\Column(type: 'string', length: 255)]
    private $couleurBG;

    #[ORM\Column(type: 'array', nullable: true)]
    private $destination = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\OneToMany(mappedBy: 'statut', targetEntity: Demande::class)]
    private $demandes;

    #[ORM\OneToMany(mappedBy: 'statutCommercial', targetEntity: Demande::class)]
    private $demandesStatutCommercial;

    #[ORM\OneToMany(mappedBy: 'statutCommercial2', targetEntity: Demande::class)]
    private $demandesStatutCommercial2;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->demandesStatutCommercial = new ArrayCollection();
        $this->demandesStatutCommercial2 = new ArrayCollection();
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

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getCouleurBG(): ?string
    {
        return $this->couleurBG;
    }

    public function setCouleurBG(string $couleurBG): self
    {
        $this->couleurBG = $couleurBG;

        return $this;
    }

    public function getDestination(): ?array
    {
        return $this->destination;
    }

    public function setDestination(?array $destination): self
    {
        $this->destination = $destination;

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

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setStatut($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getStatut() === $this) {
                $demande->setStatut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesStatutCommercial(): Collection
    {
        return $this->demandesStatutCommercial;
    }

    public function addDemandesStatutCommercial(Demande $demandesStatutCommercial): self
    {
        if (!$this->demandesStatutCommercial->contains($demandesStatutCommercial)) {
            $this->demandesStatutCommercial[] = $demandesStatutCommercial;
            $demandesStatutCommercial->setStatutCommercial($this);
        }

        return $this;
    }

    public function removeDemandesStatutCommercial(Demande $demandesStatutCommercial): self
    {
        if ($this->demandesStatutCommercial->removeElement($demandesStatutCommercial)) {
            // set the owning side to null (unless already changed)
            if ($demandesStatutCommercial->getStatutCommercial() === $this) {
                $demandesStatutCommercial->setStatutCommercial(null);
            }
        }

        return $this;
    }

    function __toString()
    {
        return $this->titre;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesStatutCommercial2(): Collection
    {
        return $this->demandesStatutCommercial2;
    }

    public function addDemandesStatutCommercial2(Demande $demandesStatutCommercial2): self
    {
        if (!$this->demandesStatutCommercial2->contains($demandesStatutCommercial2)) {
            $this->demandesStatutCommercial2[] = $demandesStatutCommercial2;
            $demandesStatutCommercial2->setStatutCommercial2($this);
        }

        return $this;
    }

    public function removeDemandesStatutCommercial2(Demande $demandesStatutCommercial2): self
    {
        if ($this->demandesStatutCommercial2->removeElement($demandesStatutCommercial2)) {
            // set the owning side to null (unless already changed)
            if ($demandesStatutCommercial2->getStatutCommercial2() === $this) {
                $demandesStatutCommercial2->setStatutCommercial2(null);
            }
        }

        return $this;
    }
}
