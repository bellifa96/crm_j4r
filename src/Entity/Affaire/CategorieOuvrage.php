<?php

namespace App\Entity\Affaire;

use App\Repository\Affaire\CategorieOuvrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieOuvrageRepository::class)]
class CategorieOuvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Ouvrage::class)]
    private Collection $ouvrages;

    public function __construct()
    {
        $this->ouvrages = new ArrayCollection();
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
            $ouvrage->setCategorie($this);
        }

        return $this;
    }

    public function removeOuvrage(Ouvrage $ouvrage): self
    {
        if ($this->ouvrages->removeElement($ouvrage)) {
            // set the owning side to null (unless already changed)
            if ($ouvrage->getCategorie() === $this) {
                $ouvrage->setCategorie(null);
            }
        }

        return $this;
    }
}
