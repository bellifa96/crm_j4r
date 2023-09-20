<?php

namespace App\Entity\Article;

use App\Entity\TimesTrait;
use App\Repository\Article\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[Gedmo\Loggable]

class Article
{

    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $titre;


    #[Gedmo\Versioned]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float')]
    private $prix;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float')]
    private $prixLocation;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float', nullable: true)]
    private $prixFournisseur;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrixLocation(): ?float
    {
        return $this->prixLocation;
    }

    public function setPrixLocation(float $prixLocation): self
    {
        $this->prixLocation = $prixLocation;

        return $this;
    }

    public function getPrixFournisseur(): ?float
    {
        return $this->prixFournisseur;
    }

    public function setPrixFournisseur(?float $prixFournisseur): self
    {
        $this->prixFournisseur = $prixFournisseur;

        return $this;
    }
}
