<?php

namespace App\Entity\Depot;

use App\Repository\Depot\BonsdetailstempRepository;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: BonsdetailstempRepository::class)]

class Bonsdetailstemp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $numaffaire;

    #[ORM\Column(type: 'integer')]

    private $numbon;

    #[ORM\Column(type: 'string')]

    private $datemvt;

    #[ORM\Column(type: 'string')]

    private $typebon;

    #[ORM\Column(type: 'string')]

    private $codearticle;



    #[ORM\Column(type: 'string')]

    private $designation;

    #[ORM\Column(type: 'integer')]

    private $qte;

    #[ORM\Column(type: 'float')]

    private $poids;
    public function getId(): ?int
    {
        return $this->id;
    }

    // No setId method for auto-generated IDs

    // Getter and Setter for $numaffaire
    public function getNumAffaire(): ?string
    {
        return $this->numaffaire;
    }

    public function setNumAffaire(?string $numaffaire): self
    {
        $this->numaffaire = $numaffaire;
        return $this;
    }

    // Repeat the pattern for the remaining properties...

    // Getter and Setter for $poids
    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): self
    {
        $this->poids = $poids;
        return $this;
    }

        public function getNumbon(): ?int
    {
        return $this->numbon;
    }

    public function setNumbon(?int $numbon): self
    {
        $this->numbon = $numbon;
        return $this;
    }

    // Getter and Setter for $datemvt
    public function getDatemvt(): ?string
    {
        return $this->datemvt;
    }

    public function setDatemvt(?string $datemvt): self
    {
        $this->datemvt = $datemvt;
        return $this;
    }

    // Getter and Setter for $typebon
    public function getTypebon(): ?string
    {
        return $this->typebon;
    }

    public function setTypebon(?string $typebon): self
    {
        $this->typebon = $typebon;
        return $this;
    }

    // Getter and Setter for $codearticle
    public function getCodearticle(): ?string
    {
        return $this->codearticle;
    }

    public function setCodearticle(?string $codearticle): self
    {
        $this->codearticle = $codearticle;
        return $this;
    }

    // Getter and Setter for $designation
    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;
        return $this;
    }

    // Getter and Setter for $qte
    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(?int $qte): self
    {
        $this->qte = $qte;
        return $this;
    }

}
