<?php

namespace App\Entity\Affaire;

use App\Repository\Affaire\TableDePrixRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableDePrixRepository::class)]
class TableDePrix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'tableDePrix')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeComposant $composant = null;

    #[ORM\ManyToOne(inversedBy: 'tableDePrix')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeOuvrage $typeOuvrage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getComposant(): ?TypeComposant
    {
        return $this->composant;
    }

    public function setComposant(?TypeComposant $composant): self
    {
        $this->composant = $composant;

        return $this;
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
}
