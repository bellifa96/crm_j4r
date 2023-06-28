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

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'longueurs')]
    private ?self $metre = null;

    #[ORM\OneToMany(mappedBy: 'metre', targetEntity: self::class)]
    private Collection $longueurs;

    public function __construct()
    {
        $this->longueurs = new ArrayCollection();
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

    public function getMetre(): ?self
    {
        return $this->metre;
    }

    public function setMetre(?self $metre): self
    {
        $this->metre = $metre;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getLongueurs(): Collection
    {
        return $this->longueurs;
    }

    public function addLongueur(self $longueur): self
    {
        if (!$this->longueurs->contains($longueur)) {
            $this->longueurs->add($longueur);
            $longueur->setMetre($this);
        }

        return $this;
    }

    public function removeLongueur(self $longueur): self
    {
        if ($this->longueurs->removeElement($longueur)) {
            // set the owning side to null (unless already changed)
            if ($longueur->getMetre() === $this) {
                $longueur->setMetre(null);
            }
        }

        return $this;
    }
}
