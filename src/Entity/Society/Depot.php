<?php

namespace App\Entity\Society;

use App\Repository\Society\DepotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepotRepository::class)]
class Depot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $CodeDepot = null;

    #[ORM\Column(length: 255)]
    private ?string $NomDepot = null;

    #[ORM\Column(length: 255)]
    private ?string $AdresseDepot = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $AdresseDepot2 = null;

    #[ORM\Column(length: 10)]
    private ?string $CpDepot = null;

    #[ORM\Column(length: 100)]
    private ?string $VilleDepot = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ContactNom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ContactPrenom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $ContactTel = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $ContactPortable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $InfoOuverture = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $ContactEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaires = null;

    #[ORM\Column]
    private ?int $IdAgence = null;

    #[ORM\Column(nullable: true)]
    private ?int $CodeChantier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeDepot(): ?int
    {
        return $this->CodeDepot;
    }

    public function setCodeDepot(int $CodeDepot): self
    {
        $this->CodeDepot = $CodeDepot;

        return $this;
    }

    public function getNomDepot(): ?string
    {
        return $this->NomDepot;
    }

    public function setNomDepot(string $NomDepot): self
    {
        $this->NomDepot = $NomDepot;

        return $this;
    }

    public function getAdresseDepot(): ?string
    {
        return $this->AdresseDepot;
    }

    public function setAdresseDepot(string $AdresseDepot): self
    {
        $this->AdresseDepot = $AdresseDepot;

        return $this;
    }

    public function getAdresseDepot2(): ?string
    {
        return $this->AdresseDepot2;
    }

    public function setAdresseDepot2(?string $AdresseDepot2): self
    {
        $this->AdresseDepot2 = $AdresseDepot2;

        return $this;
    }

    public function getCpDepot(): ?string
    {
        return $this->CpDepot;
    }

    public function setCpDepot(string $CpDepot): self
    {
        $this->CpDepot = $CpDepot;

        return $this;
    }

    public function getVilleDepot(): ?string
    {
        return $this->VilleDepot;
    }

    public function setVilleDepot(string $VilleDepot): self
    {
        $this->VilleDepot = $VilleDepot;

        return $this;
    }

    public function getContactNom(): ?string
    {
        return $this->ContactNom;
    }

    public function setContactNom(?string $ContactNom): self
    {
        $this->ContactNom = $ContactNom;

        return $this;
    }

    public function getContactPrenom(): ?string
    {
        return $this->ContactPrenom;
    }

    public function setContactPrenom(?string $ContactPrenom): self
    {
        $this->ContactPrenom = $ContactPrenom;

        return $this;
    }

    public function getContactTel(): ?string
    {
        return $this->ContactTel;
    }

    public function setContactTel(?string $ContactTel): self
    {
        $this->ContactTel = $ContactTel;

        return $this;
    }

    public function getContactPortable(): ?string
    {
        return $this->ContactPortable;
    }

    public function setContactPortable(?string $ContactPortable): self
    {
        $this->ContactPortable = $ContactPortable;

        return $this;
    }

    public function getInfoOuverture(): ?string
    {
        return $this->InfoOuverture;
    }

    public function setInfoOuverture(?string $InfoOuverture): self
    {
        $this->InfoOuverture = $InfoOuverture;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->ContactEmail;
    }

    public function setContactEmail(?string $ContactEmail): self
    {
        $this->ContactEmail = $ContactEmail;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): self
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getIdAgence(): ?int
    {
        return $this->IdAgence;
    }

    public function setIdAgence(int $IdAgence): self
    {
        $this->IdAgence = $IdAgence;

        return $this;
    }

    public function getCodeChantier(): ?int
    {
        return $this->CodeChantier;
    }

    public function setCodeChantier(?int $CodeChantier): self
    {
        $this->CodeChantier = $CodeChantier;

        return $this;
    }
}
