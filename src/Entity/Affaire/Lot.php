<?php

namespace App\Entity\Affaire;

use App\Entity\TimesTrait;
use App\Entity\User;
use App\Repository\Affaire\LotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: LotRepository::class)]
#[Gedmo\Loggable]
class Lot
{
    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $titre;

    #[Gedmo\Versioned]
    #[ORM\ManyToOne(targetEntity: User::class)]
    private $createur;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: SousLot::class)]
    private $sousLots;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $code;

    public function __construct()
    {
        $this->sousLots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

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

    /**
     * @return Collection<int, SousLot>
     */
    public function getSousLots(): Collection
    {
        return $this->sousLots;
    }

    public function addSousLot(SousLot $sousLot): self
    {
        if (!$this->sousLots->contains($sousLot)) {
            $this->sousLots[] = $sousLot;
            $sousLot->setLot($this);
        }

        return $this;
    }

    public function removeSousLot(SousLot $sousLot): self
    {
        if ($this->sousLots->removeElement($sousLot)) {
            // set the owning side to null (unless already changed)
            if ($sousLot->getLot() === $this) {
                $sousLot->setLot(null);
            }
        }

        return $this;
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
