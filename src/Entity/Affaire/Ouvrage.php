<?php

namespace App\Entity\Affaire;

use App\Entity\TimesTrait;
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
    private $titre;

    #[ORM\ManyToOne(targetEntity: SousLot::class, inversedBy: 'ouvrages')]
    #[ORM\JoinColumn(nullable: false)]
    private $sousLot;

    #[ORM\OneToMany(mappedBy: 'ouvrage', targetEntity: Commposant::class)]
    private $commposants;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDOuvrage;

    #[ORM\Column(type: 'string', length: 255)]
    private $code;

    #[ORM\Column(type: 'float')]
    private $prixUnitaireDebourse;

    #[ORM\Column(type: 'integer')]
    private $quantiteDOuvrage;

    #[ORM\Column(type: 'float')]
    private $debourseHTCalcule;

    #[ORM\Column(type: 'float')]
    private $marge;

    #[ORM\Column(type: 'float')]
    private $prixDeVenteHT;

    #[ORM\ManyToOne(targetEntity: Lot::class, inversedBy: 'ouvrages')]
    private $lot;

    public function __construct()
    {
        $this->commposants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    /**
     * @return Collection<int, Commposant>
     */
    public function getCommposants(): Collection
    {
        return $this->commposants;
    }

    public function addCommposant(Commposant $commposant): self
    {
        if (!$this->commposants->contains($commposant)) {
            $this->commposants[] = $commposant;
            $commposant->setOuvrage($this);
        }

        return $this;
    }

    public function removeCommposant(Commposant $commposant): self
    {
        if ($this->commposants->removeElement($commposant)) {
            // set the owning side to null (unless already changed)
            if ($commposant->getOuvrage() === $this) {
                $commposant->setOuvrage(null);
            }
        }

        return $this;
    }

    public function getTypeDOuvrage(): ?string
    {
        return $this->typeDOuvrage;
    }

    public function setTypeDOuvrage(string $typeDOuvrage): self
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

    public function getQuantiteDOuvrage(): ?int
    {
        return $this->quantiteDOuvrage;
    }

    public function setQuantiteDOuvrage(int $quantiteDOuvrage): self
    {
        $this->quantiteDOuvrage = $quantiteDOuvrage;

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

    public function setMarge(float $marge): self
    {
        $this->marge = $marge;

        return $this;
    }

    public function getPrixDeVenteHT(): ?float
    {
        return $this->prixDeVenteHT;
    }

    public function setPrixDeVenteHT(float $prixDeVenteHT): self
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
}
