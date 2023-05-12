<?php

namespace App\Entity\Affaire;

use App\Repository\Affaire\OuvrageFiltreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OuvrageFiltreRepository::class)]
class OuvrageFiltre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?TypeOuvrage $typeOuvrage = null;

    #[ORM\ManyToOne]
    private ?CategorieOuvrage $categorieOuvrage = null;

    #[ORM\OneToOne(inversedBy: 'ouvrageFiltre', cascade: ['persist', 'remove'])]
    private ?Ouvrage $ouvrage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeOuvrage(): ?TypeOuvrage
    {
        return $this->typeOuvrage;
    }

    public function setTypeOuvrage(?TypeOuvrage $typeOuvrage): self
    {
        $this->typeOuvrage = $typeOuvrage;

        return $this;
    }

    public function getCategorieOuvrage(): ?CategorieOuvrage
    {
        return $this->categorieOuvrage;
    }

    public function setCategorieOuvrage(?CategorieOuvrage $categorieOuvrage): self
    {
        $this->categorieOuvrage = $categorieOuvrage;

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
