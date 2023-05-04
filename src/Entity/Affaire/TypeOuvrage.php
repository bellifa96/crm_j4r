<?php

namespace App\Entity\Affaire;

use App\Entity\affaire\Ouvrage;
use App\Repository\Affaire\TypeOuvrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeOuvrageRepository::class)]
class TypeOuvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couleur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couleurText = null;

    #[ORM\OneToMany(mappedBy: 'TypeOuvrage', targetEntity: Ouvrage::class)]
    private Collection $ouvrages;

    #[ORM\OneToMany(mappedBy: 'typeOuvrage', targetEntity: TableDePrix::class, orphanRemoval: true)]
    private Collection $tableDePrix;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $categorieOuvrage = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $largeurMaillePrincipale = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $longueurMaillePrincipale = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $complexite = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $phasage = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $periode = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $consoleInterieure = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $gardeCorpsInterieur = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $niveau = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $accessibilite = [];

    public function __construct()
    {
        $this->ouvrages = new ArrayCollection();
        $this->tableDePrix = new ArrayCollection();
        $this->categorieOuvrage = [];
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

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getCouleurText(): ?string
    {
        return $this->couleurText;
    }

    public function setCouleurText(?string $couleurText): self
    {
        $this->couleurText = $couleurText;

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
            $this->ouvrages->add($ouvrage);
            $ouvrage->setTypeOuvrage($this);
        }

        return $this;
    }

    public function removeOuvrage(Ouvrage $ouvrage): self
    {
        if ($this->ouvrages->removeElement($ouvrage)) {
            // set the owning side to null (unless already changed)
            if ($ouvrage->getTypeOuvrage() === $this) {
                $ouvrage->setTypeOuvrage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TableDePrix>
     */
    public function getTableDePrix(): Collection
    {
        return $this->tableDePrix;
    }

    public function addTableDePrix(TableDePrix $tableDePrix): self
    {
        if (!$this->tableDePrix->contains($tableDePrix)) {
            $this->tableDePrix->add($tableDePrix);
            $tableDePrix->setTypeOuvrage($this);
        }

        return $this;
    }

    public function removeTableDePrix(TableDePrix $tableDePrix): self
    {
        if ($this->tableDePrix->removeElement($tableDePrix)) {
            // set the owning side to null (unless already changed)
            if ($tableDePrix->getTypeOuvrage() === $this) {
                $tableDePrix->setTypeOuvrage(null);
            }
        }

        return $this;
    }

    public function getCategorieOuvrage(): array
    {
        return $this->categorieOuvrage;
    }

    public function setCategorieOuvrage(?array $categorieOuvrage): self
    {
        $this->categorieOuvrage = $categorieOuvrage;

        return $this;
    }

    public function getLargeurMaillePrincipale(): array
    {
        return $this->largeurMaillePrincipale;
    }

    public function setLargeurMaillePrincipale(?array $largeurMaillePrincipale): self
    {
        $this->largeurMaillePrincipale = $largeurMaillePrincipale;

        return $this;
    }

    public function getLongueurMaillePrincipale(): array
    {
        return $this->longueurMaillePrincipale;
    }

    public function setLongueurMaillePrincipale(?array $longueurMaillePrincipale): self
    {
        $this->longueurMaillePrincipale = $longueurMaillePrincipale;

        return $this;
    }

    public function getComplexite(): array
    {
        return $this->complexite;
    }

    public function setComplexite(?array $complexite): self
    {
        $this->complexite = $complexite;

        return $this;
    }

    public function getPhasage(): array
    {
        return $this->phasage;
    }

    public function setPhasage(?array $phasage): self
    {
        $this->phasage = $phasage;

        return $this;
    }

    public function getPeriode(): array
    {
        return $this->periode;
    }

    public function setPeriode(?array $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getConsoleInterieure(): array
    {
        return $this->consoleInterieure;
    }

    public function setConsoleInterieure(?array $consoleInterieure): self
    {
        $this->consoleInterieure = $consoleInterieure;

        return $this;
    }

    public function getGardeCorpsInterieur(): array
    {
        return $this->gardeCorpsInterieur;
    }

    public function setGardeCorpsInterieur(?array $gardeCorpsInterieur): self
    {
        $this->gardeCorpsInterieur = $gardeCorpsInterieur;

        return $this;
    }

    public function getNiveau(): array
    {
        return $this->niveau;
    }

    public function setNiveau(?array $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getAccessibilite(): array
    {
        return $this->accessibilite;
    }

    public function setAccessibilite(?array $accessibilite): self
    {
        $this->accessibilite = $accessibilite;

        return $this;
    }
}
