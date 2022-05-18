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
}
