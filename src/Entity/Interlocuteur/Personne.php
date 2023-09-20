<?php

namespace App\Entity\Interlocuteur;

use App\Entity\AdresseTrait;
use App\Repository\Interlocuteur\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[Gedmo\Loggable]
class Personne
{

    use AdresseTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $nom;


    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\OneToOne(mappedBy: 'personne', targetEntity: Interlocuteur::class, cascade: ['persist', 'remove'])]
    private $interlocuteur;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

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


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getInterlocuteur(): ?Interlocuteur
    {
        return $this->interlocuteur;
    }

    public function setInterlocuteur(?Interlocuteur $interlocuteur): self
    {
        // unset the owning side of the relation if necessary
        if ($interlocuteur === null && $this->interlocuteur !== null) {
            $this->interlocuteur->setPersonne(null);
        }

        // set the owning side of the relation if necessary
        if ($interlocuteur !== null && $interlocuteur->getPersonne() !== $this) {
            $interlocuteur->setPersonne($this);
        }

        $this->interlocuteur = $interlocuteur;

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
}
