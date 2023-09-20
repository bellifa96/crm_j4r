<?php

namespace App\Entity\Interlocuteur;

use App\Repository\Interlocuteur\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
#[UniqueEntity(fields: ['titre'], message: 'There is already an activity with this title')]

class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255,unique: true)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\OneToMany(mappedBy: 'activitePrincipale', targetEntity: Societe::class)]
    private $societes;

    #[ORM\ManyToMany(targetEntity: Societe::class, mappedBy: 'activitesSecondaires')]
    private $societesSecondaires;


    public function __construct()
    {
        $this->societes = new ArrayCollection();
        $this->societesSecondaires = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Societe>
     */
    public function getSocietes(): Collection
    {
        return $this->societes;
    }

    public function addSociete(Societe $societe): self
    {
        if (!$this->societes->contains($societe)) {
            $this->societes[] = $societe;
            $societe->setActivitePrincipale($this);
        }

        return $this;
    }

    public function removeSociete(Societe $societe): self
    {
        if ($this->societes->removeElement($societe)) {
            // set the owning side to null (unless already changed)
            if ($societe->getActivitePrincipale() === $this) {
                $societe->setActivitePrincipale(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Societe>
     */
    public function getSocietesSecondaires(): Collection
    {
        return $this->societesSecondaires;
    }

    public function addSocietesSecondaire(Societe $societesSecondaire): self
    {
        if (!$this->societesSecondaires->contains($societesSecondaire)) {
            $this->societesSecondaires[] = $societesSecondaire;
            $societesSecondaire->addActivitesSecondaire($this);
        }

        return $this;
    }

    public function removeSocietesSecondaire(Societe $societesSecondaire): self
    {
        if ($this->societesSecondaires->removeElement($societesSecondaire)) {
            $societesSecondaire->removeActivitesSecondaire($this);
        }

        return $this;
    }

}
