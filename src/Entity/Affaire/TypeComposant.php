<?php

namespace App\Entity\Affaire;

use App\Repository\Affaire\TypeComposantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeComposantRepository::class)]
class TypeComposant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $couleur;

    #[ORM\OneToMany(mappedBy: 'typeComposant', targetEntity: Composant::class)]
    private $composants;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $couleurText;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unite = null;

    #[ORM\OneToMany(mappedBy: 'composant', targetEntity: TableDePrix::class, orphanRemoval: true)]
    private Collection $tableDePrix;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    public function __construct()
    {
        $this->composants = new ArrayCollection();
        $this->tableDePrix = new ArrayCollection();
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
            $composant->setTypeComposant($this);
        }

        return $this;
    }

    public function removeComposant(Composant $composant): self
    {
        if ($this->composants->removeElement($composant)) {
            // set the owning side to null (unless already changed)
            if ($composant->getTypeComposant() === $this) {
                $composant->setTypeComposant(null);
            }
        }

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

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(?string $unite): self
    {
        $this->unite = $unite;

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
            $tableDePrix->setComposant($this);
        }

        return $this;
    }

    public function removeTableDePrix(TableDePrix $tableDePrix): self
    {
        if ($this->tableDePrix->removeElement($tableDePrix)) {
            // set the owning side to null (unless already changed)
            if ($tableDePrix->getComposant() === $this) {
                $tableDePrix->setComposant(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->titre;
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
}
