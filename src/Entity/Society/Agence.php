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
    private ?int $agence = null;

    #[ORM\Column(length: 100)]
    private ?string $nomAgence = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseAgence = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseAgence2 = null;

    #[ORM\Column(length: 10)]
    private ?string $cpAgence = null;

    #[ORM\Column(length: 100)]
    private ?string $villeAgence = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $contactNom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $contactPrenom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $contactTel = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $contactPortable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $infoOuverture = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $contactEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgence(): ?int
    {
        return $this->agence;
    }

    public function setAgence(int $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    public function getNomAgence(): ?string
    {
        return $this->nomAgence;
    }

    public function setNomAgence(string $nomAgence): self
    {
        $this->nomAgence = $nomAgence;

        return $this;
    }

    public function getAdresseAgence(): ?string
    {
        return $this->adresseAgence;
    }

    public function setAdresseAgence(string $adresseAgence): self
    {
        $this->adresseAgence = $adresseAgence;

        return $this;
    }

    public function getAdresseAgence2(): ?string
    {
        return $this->adresseAgence2;
    }

    public function setAdresseAgence2(?string $adresseAgence2): self
    {
        $this->adresseAgence2 = $adresseAgence2;

        return $this;
    }

    public function getCpAgence(): ?string
    {
        return $this->cpAgence;
    }

    public function setCpAgence(string $cpAgence): self
    {
        $this->cpAgence = $cpAgence;

        return $this;
    }

    public function getVilleAgence(): ?string
    {
        return $this->villeAgence;
    }

    public function setVilleAgence(string $villeAgence): self
    {
        $this->villeAgence = $villeAgence;

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
}
