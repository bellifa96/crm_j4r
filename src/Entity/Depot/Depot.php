<?php

namespace App\Entity\Depot;

use App\Repository\Depot\DepotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepotRepository::class)]
class Depot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $iddepot;

    
    #[ORM\Column(type: 'integer')]
    private $codedepot = '0';

    
    #[ORM\Column(type: 'string')]
    private $nomdepot = '';

    
    #[ORM\Column(type: 'string')]
    private $adressedepot = '';

    
    #[ORM\Column(type: 'string')]
    private $adressedepot2 = '';

    
    #[ORM\Column(type: 'string')]
    private $cpdepot = '';

    
    #[ORM\Column(type: 'string')]
    private $villedepot = '';

    
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

    #[ORM\Column(type: 'integer')]
    private $codechantier = '0';

    #[ORM\ManyToOne(targetEntity:Agence::class, inversedBy: 'depots')]
    #[ORM\JoinColumn(name:'idagence', referencedColumnName:'idagence')]
    private Agence $agence;


    #[ORM\OneToMany(targetEntity: Mouvements::class, mappedBy: "idagence")]
    private $mouvements;

   




    public function __construct()
    {
        $this->mouvements = new ArrayCollection();
    }
    /**
    * @return Collection|Mouvements[]
    */
    public function getMouvements(): Collection
    {
        return $this->mouvements;
    }

    public function getIddepot(): ?string
    {
        return $this->iddepot;
    }

    public function getCodedepot(): ?int
    {
        return $this->codedepot;
    }

    public function setCodedepot(?int $codedepot): static
    {
        $this->codedepot = $codedepot;

        return $this;
    }

    public function getNomdepot(): ?string
    {
        return $this->nomdepot;
    }

    public function setNomdepot(?string $nomdepot): static
    {
        $this->nomdepot = $nomdepot;

        return $this;
    }

    public function getAdressedepot(): ?string
    {
        return $this->adressedepot;
    }

    public function setAdressedepot(?string $adressedepot): static
    {
        $this->adressedepot = $adressedepot;

        return $this;
    }

    public function getAdressedepot2(): ?string
    {
        return $this->adressedepot2;
    }

    public function setAdressedepot2(?string $adressedepot2): static
    {
        $this->adressedepot2 = $adressedepot2;

        return $this;
    }

    public function getCpdepot(): ?string
    {
        return $this->cpdepot;
    }

    public function setCpdepot(?string $cpdepot): static
    {
        $this->cpdepot = $cpdepot;

        return $this;
    }

    public function getVilledepot(): ?string
    {
        return $this->villedepot;
    }

    public function setVilledepot(?string $villedepot): static
    {
        $this->villedepot = $villedepot;

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

    public function getCodechantier(): ?int
    {
        return $this->codechantier;
    }

    public function setCodechantier(?int $codechantier): static
    {
        $this->codechantier = $codechantier;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): static
    {
        $this->agence = $agence;

        return $this;
    }


}
