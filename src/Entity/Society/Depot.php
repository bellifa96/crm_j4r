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
    private ?int $codeDepot = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDepot = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseDepot = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseDepot2 = null;

    #[ORM\Column(length: 10)]
    private ?string $cpDepot = null;

    #[ORM\Column(length: 100)]
    private ?string $villeDepot = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $contactNom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $contactPrenom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $contactTel = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $contactPortable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $infoOuverture = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $contactEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaires = null;

    #[ORM\Column]
    private ?int $idAgence = null;

    #[ORM\Column(nullable: true)]
    private ?int $codeChantier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeDepot(): ?int
    {
        return $this->codeDepot;
    }

    public function setCodeDepot(int $codeDepot): self
    {
        $this->codeDepot = $codeDepot;

        return $this;
    }

    public function getNomDepot(): ?string
    {
        return $this->nomDepot;
    }

    public function setNomDepot(string $nomDepot): self
    {
        $this->nomDepot = $nomDepot;

        return $this;
    }

    public function getAdresseDepot(): ?string
    {
        return $this->adresseDepot;
    }

    public function setAdresseDepot(string $adresseDepot): self
    {
        $this->adresseDepot = $adresseDepot;

        return $this;
    }

    public function getAdresseDepot2(): ?string
    {
        return $this->adresseDepot2;
    }

    public function setAdresseDepot2(?string $adresseDepot2): self
    {
        $this->adresseDepot2 = $adresseDepot2;

        return $this;
    }

    public function getCpDepot(): ?string
    {
        return $this->cpDepot;
    }

    public function setCpDepot(string $cpDepot): self
    {
        $this->cpDepot = $cpDepot;

        return $this;
    }

    public function getVilleDepot(): ?string
    {
        return $this->villeDepot;
    }

    public function setVilleDepot(string $villeDepot): self
    {
        $this->villeDepot = $villeDepot;

        return $this;
    }

    public function getContactNom(): ?string
    {
        return $this->contactNom;
    }

    public function setContactNom(?string $contactNom): self
    {
        $this->contactNom = $contactNom;

        return $this;
    }

    public function getContactPrenom(): ?string
    {
        return $this->contactPrenom;
    }

    public function setContactPrenom(?string $contactPrenom): self
    {
        $this->contactPrenom = $contactPrenom;

        return $this;
    }

    public function getContactTel(): ?string
    {
        return $this->contactTel;
    }

    public function setContactTel(?string $contactTel): self
    {
        $this->contactTel = $contactTel;

        return $this;
    }

    public function getContactPortable(): ?string
    {
        return $this->contactPortable;
    }

    public function setContactPortable(?string $contactPortable): self
    {
        $this->contactPortable = $contactPortable;

        return $this;
    }

    public function getInfoOuverture(): ?string
    {
        return $this->infoOuverture;
    }

    public function setInfoOuverture(?string $infoOuverture): self
    {
        $this->infoOuverture = $infoOuverture;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): self
    {
        $this->contactEmail = $contactEmail;

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
        return $this->idAgence;
    }

    public function setIdAgence(int $idAgence): self
    {
        $this->idAgence = $idAgence;

        return $this;
    }

    public function getCodeChantier(): ?int
    {
        return $this->codeChantier;
    }

    public function setCodeChantier(?int $codeChantier): self
    {
        $this->codeChantier = $codeChantier;

        return $this;
    }
}
