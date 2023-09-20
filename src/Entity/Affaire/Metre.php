<?php

namespace App\Entity\Affaire;

use App\Repository\Affaire\MetreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetreRepository::class)]
class Metre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lineaire = null;

    #[ORM\Column(nullable: true)]
    private ?float $longueur = null;

    #[ORM\Column(nullable: true)]
    private ?float $hauteur = null;

    #[ORM\ManyToOne(inversedBy: 'metres')]
    private ?Ouvrage $ouvrage = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'longueursLineaire')]
    private ?self $longueurLineaire = null;

    #[ORM\OneToMany(mappedBy: 'longueurLineaire', targetEntity: self::class)]
    private Collection $longueursLineaire;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'longueursHauteur')]
    private ?self $longueurHauteur = null;

    #[ORM\OneToMany(mappedBy: 'longueurHauteur', targetEntity: self::class)]
    private Collection $longueursHauteur;

    #[ORM\Column(length: 255)]
    private ?string $typeMetre = null;

    public function __construct()
    {
        $this->longueursLineaire = new ArrayCollection();
        $this->longueursHauteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLineaire(): ?string
    {
        return $this->lineaire;
    }

    public function setLineaire(?string $lineaire): self
    {
        $this->lineaire = $lineaire;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(?float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getHauteur(): ?float
    {
        return $this->hauteur;
    }

    public function setHauteur(?float $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getOuvrage(): ?Ouvrage
    {
        return $this->ouvrage;
    }

    public function setOuvrage(?Ouvrage $ouvrage): self
    {
        $this->ouvrage = $ouvrage;

        return $this;
    }

    public function getLongueurLineaire(): ?self
    {
        return $this->longueurLineaire;
    }

    public function setLongueurLineaire(?self $longueurLineaire): self
    {
        $this->longueurLineaire = $longueurLineaire;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getLongueursLineaire(): Collection
    {
        return $this->longueursLineaire;
    }

    public function addLongueursLineaire(self $longueursLineaire): self
    {
        if (!$this->longueursLineaire->contains($longueursLineaire)) {
            $this->longueursLineaire->add($longueursLineaire);
            $longueursLineaire->setLongueurLineaire($this);
        }

        return $this;
    }

    public function removeLongueursLineaire(self $longueursLineaire): self
    {
        if ($this->longueursLineaire->removeElement($longueursLineaire)) {
            // set the owning side to null (unless already changed)
            if ($longueursLineaire->getLongueurLineaire() === $this) {
                $longueursLineaire->setLongueurLineaire(null);
            }
        }

        return $this;
    }

    public function getLongueurHauteur(): ?self
    {
        return $this->longueurHauteur;
    }

    public function setLongueurHauteur(?self $longueurHauteur): self
    {
        $this->longueurHauteur = $longueurHauteur;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getLongueursHauteur(): Collection
    {
        return $this->longueursHauteur;
    }

    public function addLongueursHauteur(self $longueursHauteur): self
    {
        if (!$this->longueursHauteur->contains($longueursHauteur)) {
            $this->longueursHauteur->add($longueursHauteur);
            $longueursHauteur->setLongueurHauteur($this);
        }

        return $this;
    }

    public function removeLongueursHauteur(self $longueursHauteur): self
    {
        if ($this->longueursHauteur->removeElement($longueursHauteur)) {
            // set the owning side to null (unless already changed)
            if ($longueursHauteur->getLongueurHauteur() === $this) {
                $longueursHauteur->setLongueurHauteur(null);
            }
        }

        return $this;
    }

    public function getTypeMetre(): ?string
    {
        return $this->typeMetre;
    }

    public function setTypeMetre(string $typeMetre): self
    {
        $this->typeMetre = $typeMetre;

        return $this;
    }
}
