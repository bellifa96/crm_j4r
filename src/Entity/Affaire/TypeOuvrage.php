<?php

namespace App\Entity\Affaire;

use App\Entity\affaire\Ouvrage;
use App\Repository\Affaire\TypeOuvrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeOuvrageRepository::class)]
class TypeOuvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couleur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couleurText = null;

    #[ORM\OneToMany(mappedBy: 'TypeOuvrage', targetEntity: Ouvrage::class)]
    private Collection $ouvrages;

    #[ORM\OneToMany(mappedBy: 'typeOuvrage', targetEntity: TableDePrix::class, orphanRemoval: true)]
    private Collection $tableDePrix;

    public function __construct()
    {
        $this->ouvrages = new ArrayCollection();
        $this->tableDePrix = new ArrayCollection();
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

    public function getCouleurText(): ?string
    {
        return $this->couleurText;
    }

    public function setCouleurText(?string $couleurText): self
    {
        $this->couleurText = $couleurText;

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
            $ouvrage->setTypeOuvrage($this);
        }

        return $this;
    }

    public function removeOuvrage(Ouvrage $ouvrage): self
    {
        if ($this->ouvrages->removeElement($ouvrage)) {
            // set the owning side to null (unless already changed)
            if ($ouvrage->getTypeOuvrage() === $this) {
                $ouvrage->setTypeOuvrage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TableDePrix>
     */
    public function getTableDePrix(): Collection
    {
        return $this->tableDePrix;
    }

    public function addTableDePrix(TableDePrix $tableDePrix): self
    {
        if (!$this->tableDePrix->contains($tableDePrix)) {
            $this->tableDePrix->add($tableDePrix);
            $tableDePrix->setTypeOuvrage($this);
        }

        return $this;
    }

    public function removeTableDePrix(TableDePrix $tableDePrix): self
    {
        if ($this->tableDePrix->removeElement($tableDePrix)) {
            // set the owning side to null (unless already changed)
            if ($tableDePrix->getTypeOuvrage() === $this) {
                $tableDePrix->setTypeOuvrage(null);
            }
        }

        return $this;
    }
}
