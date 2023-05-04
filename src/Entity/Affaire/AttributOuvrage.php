<?php

namespace App\Entity\Affaire;

use App\Repository\Affaire\AttributOuvrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributOuvrageRepository::class)]
class AttributOuvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(nullable:true)]
    private ?float $poidsKG = null;

    #[ORM\Column(length: 255,nullable:true)]
    private ?string $tps = null;


    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'attributOuvrageTrs')]
    private ?self $attributOuvrage = null;

    #[ORM\OneToMany(mappedBy: 'attributOuvrage', targetEntity: self::class)]
    private Collection $attributOuvrageTrs;

    #[ORM\Column]
    private ?bool $isTable = null;

    public function __construct()
    {
        $this->attributOuvrageTrs = new ArrayCollection();
        $this->isTable = false;
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

    public function getPoidsKG(): ?float
    {
        return $this->poidsKG;
    }

    public function setPoidsKG(?float $poidsKG): self
    {
        $this->poidsKG = $poidsKG;

        return $this;
    }

    public function getTps(): ?string
    {
        return $this->tps;
    }

    public function setTps(?string $tps): self
    {
        $this->tps = $tps;

        return $this;
    }

    public function getAttributOuvrage(): ?self
    {
        return $this->attributOuvrage;
    }

    public function setAttributOuvrage(?self $attributOuvrage): self
    {
        $this->attributOuvrage = $attributOuvrage;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getAttributOuvrageTrs(): Collection
    {
        return $this->attributOuvrageTrs;
    }

    public function addAttributOuvrageTr(self $attributOuvrageTr): self
    {
        if (!$this->attributOuvrageTrs->contains($attributOuvrageTr)) {
            $this->attributOuvrageTrs->add($attributOuvrageTr);
            $attributOuvrageTr->setAttributOuvrage($this);
        }

        return $this;
    }

    public function removeAttributOuvrageTr(self $attributOuvrageTr): self
    {
        if ($this->attributOuvrageTrs->removeElement($attributOuvrageTr)) {
            // set the owning side to null (unless already changed)
            if ($attributOuvrageTr->getAttributOuvrage() === $this) {
                $attributOuvrageTr->setAttributOuvrage(null);
            }
        }

        return $this;
    }

    public function isIsTable(): ?bool
    {
        return $this->isTable;
    }

    public function setIsTable(bool $isTable): self
    {
        $this->isTable = $isTable;

        return $this;
    }
}
