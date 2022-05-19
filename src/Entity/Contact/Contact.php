<?php

namespace App\Entity\Contact;

use App\Entity\AdresseTrait;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Repository\Contact\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    use AdresseTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $telephoneMobile;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateAnniversaire;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    private $societe;


    #[ORM\ManyToOne(targetEntity: ContactService::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    private $service;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $fonction;

    #[ORM\Column(type: 'string', length: 255)]
    private $genre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephoneMobile(): ?string
    {
        return $this->telephoneMobile;
    }

    public function setTelephoneMobile(string $telephoneMobile): self
    {
        $this->telephoneMobile = $telephoneMobile;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDateAnniversaire(): ?string
    {
        return $this->dateAnniversaire;
    }

    public function setDateAnniversaire(?string $dateAnniversaire): self
    {
        $this->dateAnniversaire = $dateAnniversaire;

        return $this;
    }

    public function getSociete(): ?Interlocuteur
    {
        return $this->societe;
    }

    public function setSociete(?Interlocuteur $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getService(): ?ContactService
    {
        return $this->service;
    }

    public function setService(?ContactService $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
