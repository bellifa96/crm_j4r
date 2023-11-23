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
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $ligne = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?float $colonne = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $quantiteMetre = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nameColonne = null;

    #[ORM\ManyToOne(inversedBy: 'metres')]
    private ?Ouvrage $ouvrage = null;

    public function __construct()
    {
        // You can initialize properties or add any other logic here if needed
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLigne(): ?int
    {
        return $this->ligne;
    }

    public function setLigne(?int $ligne): self
    {
        $this->ligne = $ligne;

        return $this;
    }

    public function getColonne(): ?float
    {
        return $this->colonne;
    }

    public function setColonne(?float $colonne): self
    {
        $this->colonne = $colonne;

        return $this;
    }

    public function getQuantiteMetre(): ?float
    {
        return $this->quantiteMetre;
    }

    public function setQuantiteMetre(?float $quantiteMetre): self
    {
        $this->quantiteMetre = $quantiteMetre;

        return $this;
    }

    public function getNameColonne(): ?string
    {
        return $this->nameColonne;
    }

    public function setNameColonne(?string $nameColonne): self
    {
        $this->nameColonne = $nameColonne;

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
}
