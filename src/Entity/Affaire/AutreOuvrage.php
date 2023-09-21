<?php

namespace App\Entity\Affaire;

use App\Entity\Unite;
use App\Repository\Affaire\AutreOuvrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutreOuvrageRepository::class)]
class AutreOuvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'autreOuvrages')]
    private ?Unite $unite = null;

    #[ORM\Column]
    private ?float $quantite = null;

    #[ORM\Column(nullable: true)]
    private ?int $dureeLocation = null;

    #[ORM\Column(nullable: true)]
    private ?float $poids = null;

    #[ORM\Column(nullable: true)]
    private ?float $montage = null;

    #[ORM\Column(nullable: true)]
    private ?float $demontage = null;

    #[ORM\Column(nullable: true)]
    private ?float $transportAller = null;

    #[ORM\Column(nullable: true)]
    private ?float $transportRetour = null;

    #[ORM\Column(nullable: true)]
    private ?float $manutentionAppro = null;

    #[ORM\Column(nullable: true)]
    private ?float $manutentionRepli = null;

    #[ORM\Column(nullable: true)]
    private ?float $vente = null;

    #[ORM\Column(nullable: true)]
    private ?float $location = null;

    #[ORM\Column(nullable: true)]
    private ?float $marge = null;

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    #[ORM\OneToMany(mappedBy: 'autreOuvrage', targetEntity: Ouvrage::class)]
    private Collection $ouvrages;

    public function __construct()
    {
        $this->ouvrages = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDureeLocation(): ?int
    {
        return $this->dureeLocation;
    }

    public function setDureeLocation(?int $dureeLocation): self
    {
        $this->dureeLocation = $dureeLocation;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getMontage(): ?float
    {
        return $this->montage;
    }

    public function setMontage(?float $montage): self
    {
        $this->montage = $montage;

        return $this;
    }

    public function getDemontage(): ?float
    {
        return $this->demontage;
    }

    public function setDemontage(?float $demontage): self
    {
        $this->demontage = $demontage;

        return $this;
    }

    public function getTransportAller(): ?float
    {
        return $this->transportAller;
    }

    public function setTransportAller(?float $transportAller): self
    {
        $this->transportAller = $transportAller;

        return $this;
    }

    public function getTransportRetour(): ?float
    {
        return $this->transportRetour;
    }

    public function setTransportRetour(?float $transportRetour): self
    {
        $this->transportRetour = $transportRetour;

        return $this;
    }

    public function getManutentionAppro(): ?float
    {
        return $this->manutentionAppro;
    }

    public function setManutentionAppro(?float $manutentionAppro): self
    {
        $this->manutentionAppro = $manutentionAppro;

        return $this;
    }

    public function getManutentionRepli(): ?float
    {
        return $this->manutentionRepli;
    }

    public function setManutentionRepli(?float $manutentionRepli): self
    {
        $this->manutentionRepli = $manutentionRepli;

        return $this;
    }

    public function getVente(): ?float
    {
        return $this->vente;
    }

    public function setVente(?float $vente): self
    {
        $this->vente = $vente;

        return $this;
    }

    public function getLocation(): ?float
    {
        return $this->location;
    }

    public function setLocation(?float $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getMarge(): ?float
    {
        return $this->marge;
    }

    public function setMarge(?float $marge): self
    {
        $this->marge = $marge;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * @return Collection<int, Ouvrage>
     */
    public function getOuvrages(): Collection
    {
        return $this->ouvrages;
    }

    public function addOuvrage(Ouvrage $ouvrage): self
    {
        if (!$this->ouvrages->contains($ouvrage)) {
            $this->ouvrages->add($ouvrage);
            $ouvrage->setAutreOuvrage($this);
        }

        return $this;
    }

    public function removeOuvrage(Ouvrage $ouvrage): self
    {
        if ($this->ouvrages->removeElement($ouvrage)) {
            // set the owning side to null (unless already changed)
            if ($ouvrage->getAutreOuvrage() === $this) {
                $ouvrage->setAutreOuvrage(null);
            }
        }

        return $this;
    }
}
