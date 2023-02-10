<?php

namespace App\Entity\Affaire;

use App\Entity\TimesTrait;
use App\Entity\User;
use App\Repository\Affaire\OuvrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: OuvrageRepository::class)]
#[Gedmo\Loggable]
class Ouvrage
{
    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $denomination;

    #[ORM\ManyToOne(targetEntity: SousLot::class, inversedBy: 'ouvrages')]
    #[ORM\JoinColumn(nullable: true)]
    private $sousLot;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $typeDOuvrage;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Versioned]
    private $code;

    #[ORM\Column(type: 'float',nullable: true)]
    #[Gedmo\Versioned]
    private $prixUnitaireDebourse;

    #[ORM\Column(type: 'integer',nullable: true)]
    #[Gedmo\Versioned]
    private $quantite;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Gedmo\Versioned]
    private $debourseHTCalcule;

    #[ORM\Column(type: 'float',nullable: true)]
    #[Gedmo\Versioned]
    private $marge;

    #[ORM\Column(type: 'float',nullable: true)]
    #[Gedmo\Versioned]
    private $prixDeVenteHT;

    #[ORM\ManyToOne(targetEntity: Lot::class, inversedBy: 'ouvrages')]
    private $lot;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Gedmo\Versioned]
    private $unite;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ouvrages')]
    private $createur;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Gedmo\Versioned]
    private $note;

    #[ORM\ManyToMany(targetEntity: Composant::class, mappedBy: 'ouvrages')]
    private $composants;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $statut;

    public function __construct()
    {
        $this->composants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getSousLot(): ?SousLot
    {
        return $this->sousLot;
    }

    public function setSousLot(?SousLot $sousLot): self
    {
        $this->sousLot = $sousLot;

        return $this;
    }

    public function getTypeDOuvrage(): ?string
    {
        return $this->typeDOuvrage;
    }

    public function setTypeDOuvrage(?string $typeDOuvrage): self
    {
        $this->typeDOuvrage = $typeDOuvrage;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPrixUnitaireDebourse(): ?float
    {
        return $this->prixUnitaireDebourse;
    }

    public function setPrixUnitaireDebourse(float $prixUnitaireDebourse): self
    {
        $this->prixUnitaireDebourse = $prixUnitaireDebourse;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDebourseHTCalcule(): ?float
    {
        return $this->debourseHTCalcule;
    }

    public function setDebourseHTCalcule(float $debourseHTCalcule): self
    {
        $this->debourseHTCalcule = $debourseHTCalcule;

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

    public function getPrixDeVenteHT(): ?float
    {
        return $this->prixDeVenteHT;
    }

    public function setPrixDeVenteHT(?float $prixDeVenteHT): self
    {
        $this->prixDeVenteHT = $prixDeVenteHT;

        return $this;
    }

    public function getLot(): ?Lot
    {
        return $this->lot;
    }

    public function setLot(?Lot $lot): self
    {
        $this->lot = $lot;

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
     * @return Collection<int, Composant>
     */
    public function getComposants(): Collection
    {
        return $this->composants;
    }

    public function addComposant(Composant $composant): self
    {
        if (!$this->composants->contains($composant)) {
            $this->composants[] = $composant;
            $composant->addOuvrage($this);
        }

        return $this;
    }

    public function removeComposant(Composant $composant): self
    {
        if ($this->composants->removeElement($composant)) {
            $composant->removeOuvrage($this);
        }

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

}
