<?php

namespace App\Entity\Society;

use App\Repository\Society\AgenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgenceRepository::class)]
class Agence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Agence = null;

    #[ORM\Column(length: 100)]
    private ?string $NomAgence = null;

    #[ORM\Column(length: 255)]
    private ?string $AdresseAgence = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $AdresseAgence2 = null;

    #[ORM\Column(length: 10)]
    private ?string $CpAgence = null;

    #[ORM\Column(length: 100)]
    private ?string $VilleAgence = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ContactNom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ContactPrenom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $ContactTel = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $ContactPortable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $InfoOuverture = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ContactEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Commentaires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgence(): ?int
    {
        return $this->Agence;
    }

    public function setAgence(int $Agence): self
    {
        $this->Agence = $Agence;

        return $this;
    }

    public function getNomAgence(): ?string
    {
        return $this->NomAgence;
    }

    public function setNomAgence(string $NomAgence): self
    {
        $this->NomAgence = $NomAgence;

        return $this;
    }

    public function getAdresseAgence(): ?string
    {
        return $this->AdresseAgence;
    }

    public function setAdresseAgence(string $AdresseAgence): self
    {
        $this->AdresseAgence = $AdresseAgence;

        return $this;
    }

    public function getAdresseAgence2(): ?string
    {
        return $this->AdresseAgence2;
    }

    public function setAdresseAgence2(?string $AdresseAgence2): self
    {
        $this->AdresseAgence2 = $AdresseAgence2;

        return $this;
    }

    public function getCpAgence(): ?string
    {
        return $this->CpAgence;
    }

    public function setCpAgence(string $CpAgence): self
    {
        $this->CpAgence = $CpAgence;

        return $this;
    }

    public function getVilleAgence(): ?string
    {
        return $this->VilleAgence;
    }

    public function setVilleAgence(string $VilleAgence): self
    {
        $this->VilleAgence = $VilleAgence;

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
        return $this->Commentaires;
    }

    public function setCommentaires(?string $Commentaires): self
    {
        $this->Commentaires = $Commentaires;

        return $this;
    }
}
