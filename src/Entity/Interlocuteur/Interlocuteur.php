<?php

namespace App\Entity\Interlocuteur;

use App\Repository\Interlocuteur\InterlocuteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterlocuteurRepository::class)]
class Interlocuteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\OneToOne(inversedBy: 'interlocuteur', targetEntity: Personne::class, cascade: ['persist', 'remove'])]
    private $personne;

    #[ORM\OneToOne(inversedBy: 'interlocuteur', targetEntity: Societe::class, cascade: ['persist', 'remove'])]
    private $societe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getSociete(): ?Societe
    {
        return $this->societe;
    }

    public function setSociete(?Societe $societe): self
    {
        $this->societe = $societe;

        return $this;
    }
}
