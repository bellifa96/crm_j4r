<?php

namespace App\Entity\Society;

use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\TimesTrait;
use App\Repository\Society\RibRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RibRepository::class)]
class Rib
{

    use TimesTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255,unique: true)]
    private $iban;

    #[ORM\Column(type: 'string', length: 255)]
    private $bic;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDeCompte;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nomBanque;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'ribs')]
    private $interlocuteur;

    #[ORM\Column(type: 'string', length: 255)]
    private $etatDuCompte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(string $bic): self
    {
        $this->bic = $bic;

        return $this;
    }

    public function getTypeDeCompte(): ?string
    {
        return $this->typeDeCompte;
    }

    public function setTypeDeCompte(string $typeDeCompte): self
    {
        $this->typeDeCompte = $typeDeCompte;

        return $this;
    }

    public function getNomBanque(): ?string
    {
        return $this->nomBanque;
    }

    public function setNomBanque(?string $nomBanque): self
    {
        $this->nomBanque = $nomBanque;

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

    public function getInterlocuteur(): ?Interlocuteur
    {
        return $this->interlocuteur;
    }

    public function setInterlocuteur(?Interlocuteur $interlocuteur): self
    {
        $this->interlocuteur = $interlocuteur;

        return $this;
    }

    public function getEtatDuCompte(): ?string
    {
        return $this->etatDuCompte;
    }

    public function setEtatDuCompte(string $etatDuCompte): self
    {
        $this->etatDuCompte = $etatDuCompte;

        return $this;
    }
}
