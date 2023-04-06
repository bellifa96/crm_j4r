<?php

namespace App\Entity\Affaire;

use App\Entity\User;
use App\Repository\Affaire\ComposantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposantRepository::class)]
class Composant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $intitule;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $unite;

    #[ORM\Column(type: 'float')]
    private $debourseUnitaireHT;

    #[ORM\ManyToOne(targetEntity: TypeComposant::class, inversedBy: 'composants')]
    #[ORM\JoinColumn(nullable: true)]
    private $typeComposant;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $createur;

    #[ORM\Column(type: 'text', nullable: true)]
    private $note;

    #[ORM\ManyToMany(targetEntity: Ouvrage::class, inversedBy: 'composants')]
    private $ouvrages;

    #[ORM\Column(type: 'float', nullable: true)]
    private $marge;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prixDeVente;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $statut;

    #[ORM\Column(type: 'integer',nullable: false)]
    #[Gedmo\Versioned]
    private $quantite;

    public function __construct()
    {
        $this->ouvrages = new ArrayCollection();
        $this->quantite = 1;
        $this->debourseUnitaireHT = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(?string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getDebourseUnitaireHT(): ?float
    {
        return $this->debourseUnitaireHT;
    }

    public function setDebourseUnitaireHT(?float $debourseUnitaireHT): self
    {
        $this->debourseUnitaireHT = $debourseUnitaireHT;

        return $this;
    }

    public function getOuvrage(): ?Ouvrage
    {
        return $this->ouvrage;
    }

    public function setOuvrage(?Ouvrage $ouvrage): self
    {
        $this->ouvrage = $ouvrage;

        return $this;
    }

    public function getTypeComposant(): ?TypeComposant
    {
        return $this->typeComposant;
    }

    public function setTypeComposant(?TypeComposant $typeComposant): self
    {
        $this->typeComposant = $typeComposant;

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection<int, Ouvrage>
     */
    public function getOuvrages(): Collection
    {
        return $this->ouvrages;
    }

    public function addOuvrage(Ouvrage $ouvrage): self
    {
        if (!$this->ouvrages->contains($ouvrage)) {
            $this->ouvrages[] = $ouvrage;
        }

        return $this;
    }

    public function removeOuvrage(Ouvrage $ouvrage): self
    {
        $this->ouvrages->removeElement($ouvrage);

        return $this;
    }

    public function getMarge(): ?float
    {
        return $this->marge;
    }

    public function setMarge(?float $marge): self
    {
        $this->marge = $marge;

        return $this;
    }

    public function getPrixDeVente(): ?float
    {
        return $this->prixDeVente;
    }

    public function setPrixDeVente(?float $prixDeVente): self
    {
        $this->prixDeVente = $prixDeVente;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

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

}
