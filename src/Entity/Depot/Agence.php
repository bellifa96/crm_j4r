<?php

namespace App\Entity\Depot;

use App\Repository\Depot\AgenceRepository as AgenceRepository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AgenceRepository::class)]

class Agence
{

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->mouvements = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->chantiers = new ArrayCollection();

    }



    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $idagence;

    #[ORM\Column(type: 'integer')]
    private $agence;

    #[ORM\Column(type: 'string')]
    private $nomagence = '';

    #[ORM\Column(type: 'string')]
    private $adresseagence = '';

    #[ORM\Column(type: 'string')]
    private $adresseagence2 = '';

    #[ORM\Column(type: 'string')]
    private $cpagence = '';

    #[ORM\Column(type: 'string')]

    private $villeagence = '';

    #[ORM\Column(type: 'string')]
    private $contactnom = '';

    #[ORM\Column(type: 'string')]

    private $contactprenom = '';

    #[ORM\Column(type: 'string')]
    private $contacttel = '';

    #[ORM\Column(type: 'string')]
    private $contactportable = '';

    #[ORM\Column(type: 'string')]

    private $infoouverture = '';

    #[ORM\Column(type: 'string')]

    private $contactemail = '';

    #[ORM\Column(type: 'string')]

    private $commentaires = '';

    #[ORM\OneToMany(targetEntity: Depot::class, mappedBy: 'agences')]
    private Collection $depots;

    #[ORM\OneToMany(targetEntity: Mouvements::class, mappedBy: "idagence")]
    private $mouvements;

    #[ORM\OneToMany(targetEntity: Articles::class, mappedBy: "idarticles")]
    private $articles;
    #[ORM\OneToMany(targetEntity: Chantiers::class, mappedBy: "idarticles")]
    private $chantiers;

   
    
     /**
     * @return Collection|Mouvements[]
     */

    public function getArticles(): Collection
    {
        return $this->articles;
    }

     /**
     * @return Collection|Chantiers[]
     */

     public function getChantiers(): Collection
     {
         return $this->chantiers;
     }
    

    public function getIdagence(): ?string
    {
        return $this->idagence;
    }

    public function getDepot(): Collection
    {
        return $this->depots;
    }

    public function getAgence(): ?int
    {
        return $this->agence;
    }

    /**
     * @return Collection|Mouvements[]
     */
    public function getMouvements(): Collection
    {
        return $this->mouvements;
    }

    public function setAgence(?int $agence): static
    {
        $this->agence = $agence;

        return $this;
    }

    public function getNomagence(): ?string
    {
        return $this->nomagence;
    }

    public function setNomagence(?string $nomagence): static
    {
        $this->nomagence = $nomagence;

        return $this;
    }

    public function getAdresseagence(): ?string
    {
        return $this->adresseagence;
    }

    public function setAdresseagence(?string $adresseagence): static
    {
        $this->adresseagence = $adresseagence;

        return $this;
    }

    public function getAdresseagence2(): ?string
    {
        return $this->adresseagence2;
    }

    public function setAdresseagence2(?string $adresseagence2): static
    {
        $this->adresseagence2 = $adresseagence2;

        return $this;
    }

    public function getCpagence(): ?string
    {
        return $this->cpagence;
    }

    public function setCpagence(?string $cpagence): static
    {
        $this->cpagence = $cpagence;

        return $this;
    }

    public function getVilleagence(): ?string
    {
        return $this->villeagence;
    }

    public function setVilleagence(?string $villeagence): static
    {
        $this->villeagence = $villeagence;

        return $this;
    }

    public function getContactnom(): ?string
    {
        return $this->contactnom;
    }

    public function setContactnom(?string $contactnom): static
    {
        $this->contactnom = $contactnom;

        return $this;
    }

    public function getContactprenom(): ?string
    {
        return $this->contactprenom;
    }

    public function setContactprenom(?string $contactprenom): static
    {
        $this->contactprenom = $contactprenom;

        return $this;
    }

    public function getContacttel(): ?string
    {
        return $this->contacttel;
    }

    public function setContacttel(?string $contacttel): static
    {
        $this->contacttel = $contacttel;

        return $this;
    }

    public function getContactportable(): ?string
    {
        return $this->contactportable;
    }

    public function setContactportable(?string $contactportable): static
    {
        $this->contactportable = $contactportable;

        return $this;
    }

    public function getInfoouverture(): ?string
    {
        return $this->infoouverture;
    }

    public function setInfoouverture(?string $infoouverture): static
    {
        $this->infoouverture = $infoouverture;

        return $this;
    }

    public function getContactemail(): ?string
    {
        return $this->contactemail;
    }

    public function setContactemail(?string $contactemail): static
    {
        $this->contactemail = $contactemail;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }
}
