<?php

namespace App\Entity\Transport;

use App\Repository\Transport\CdeMatDetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CdeMatDetRepository::class)]
class CdeMatDet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NumDevis = null;

    #[ORM\Column]
    private ?int $CodeChantier = null;

    #[ORM\Column(length: 15)]
    private ?string $Article = null;

    #[ORM\Column(length: 255)]
    private ?string $Designation = null;

    #[ORM\Column]
    private ?int $Qte = null;

    #[ORM\Column]
    private ?int $QteSortie = null;

    #[ORM\Column]
    private ?float $Poids = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $TypeMat = null;

    #[ORM\Column]
    private ?int $IdCdeMatEnt = null;

    #[ORM\Column]
    private ?int $NumLigne = null;
    #[ORM\Column]
    private ?int $NumCloud  = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumDevis(): ?int
    {
        return $this->NumDevis;
    }

    public function setNumDevis(int $NumDevis): self
    {
        $this->NumDevis = $NumDevis;

        return $this;
    }

    public function getCodeChantier(): ?int
    {
        return $this->CodeChantier;
    }

    public function setCodeChantier(int $CodeChantier): self
    {
        $this->CodeChantier = $CodeChantier;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->Article;
    }

    public function setArticle(string $Article): self
    {
        $this->Article = $Article;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->Designation;
    }

    public function setDesignation(string $Designation): self
    {
        $this->Designation = $Designation;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->Qte;
    }

    public function setQte(int $Qte): self
    {
        $this->Qte = $Qte;

        return $this;
    }

    public function getQteSortie(): ?int
    {
        return $this->QteSortie;
    }

    public function setQteSortie(int $QteSortie): self
    {
        $this->QteSortie = $QteSortie;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->Poids;
    }

    public function setPoids(float $Poids): self
    {
        $this->Poids = $Poids;

        return $this;
    }

    public function getTypeMat(): ?string
    {
        return $this->TypeMat;
    }

    public function setTypeMat(?string $TypeMat): self
    {
        $this->TypeMat = $TypeMat;

        return $this;
    }

    public function getIdCdeMatEnt(): ?int
    {
        return $this->IdCdeMatEnt;
    }

    public function setIdCdeMatEnt(int $IdCdeMatEnt): self
    {
        $this->IdCdeMatEnt = $IdCdeMatEnt;

        return $this;
    }

    public function getNumLigne(): ?int
    {
        return $this->NumLigne;
    }

    public function setNumLigne(int $NumLigne): self
    {
        $this->NumLigne = $NumLigne;

        return $this;
    }
    public function getNumCloud(): ?int
    {
        return $this->NumCloud;
    }

    /**
     * Set the value of NumCloud
     *
     * @param int|null $NumCloud
     */
    public function setNumCloud(?int $NumCloud): void
    {
        $this->NumCloud = $NumCloud;
    }
      /**
     * Update QteSortie by adding a new value to the existing one.
     *
     * @param int $newQteSortie The value to add to the existing QteSortie
     */
    public function updateQteSortie(int $newQteSortie): void
    {
        $this->QteSortie += $newQteSortie;
    }
}
