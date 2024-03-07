<?php

namespace App\Entity;

use App\Entity\Depot\Camions;
use App\Entity\Depot\Chauffeurs;
use App\Entity\Transport\CdeMatEnt;
use App\Repository\Affaire\TransportRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TransportRepository::class)]
#[ORM\Table(name: "transports")]
class Transports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $idtransport;

    #[ORM\Column(type: 'date')]
    private $datetrans = 'NULL';

    #[ORM\Column(type: 'integer')]
    private $sens = '0';

    #[ORM\Column(type: 'string')]

    private $heuredep = 'NULL';

    #[ORM\Column(type: 'string')]

    private $heurearr = 'NULL';

    #[ORM\Column(type: 'integer')]

    private $numchantierdep = '0';

    #[ORM\Column(type: 'integer')]

    private $numchantierarr = '0';

    #[ORM\Column(type: 'string')]

    private $observation = 'NULL';

    #[ORM\Column(type: 'string')]

    private $adressechantier = 'NULL';

    #[ORM\Column(type: 'decimal')]

    private $poidsbon = '0.00';

    #[ORM\Column(type: 'decimal')]

    private $poidsbalance = '0.00';

    #[ORM\Column(type: 'decimal')]

    private $nbheuresprev = '0.00';

    #[ORM\Column(type: 'decimal')]

    private $nbheuresreal = '0.00';

    #[ORM\Column(type: 'boolean')]

    private $facturetrans = '0';

    #[ORM\Column(type: 'boolean')]

    private $envoifdr = '0';

    #[ORM\Column(type: 'string')]

    private $heuredep2 = 'NULL';

    #[ORM\Column(type: 'string')]

    private $heurearr2 = 'NULL';

    #[ORM\Column(type: 'date')]

    private $datesaisie = 'NULL';

    #[ORM\Column(type: 'integer')]

    private $tauxPrefere = '0';

    #[ORM\Column(type: 'decimal')]

    private $montant = '0';

    #[ORM\Column(type: 'boolean')]

    private $litige = '0';

    #[ORM\Column(type: 'string')]

    private $motiflitige = 'NULL';

    #[ORM\Column(type: 'boolean')]

    private $annulationtrans = '0';

    #[ORM\Column(type: 'string')]

    private $motifannulation = 'NULL';

    #[ORM\Column(type: 'boolean')]
    private $groupagecamion = '0';

    #[ORM\Column(type: 'boolean')]

    private $envoiannulemail = '0';

 
    #[ORM\ManyToOne(targetEntity:CdeMatEnt::class)]
    #[ORM\JoinColumn(name:'idcde', referencedColumnName:'id')]
    private $idcde;

    
    #[ORM\ManyToOne(targetEntity:Camions::class)]
    #[ORM\JoinColumn(name:'idcamion', referencedColumnName:'IdCamion')]
    private $idcamion;

    #[ORM\ManyToOne(targetEntity:Camions::class)]
    #[ORM\JoinColumn(name:'idcamion', referencedColumnName:'IdCamion')]
    private $idtransporteur;

   
    #[ORM\ManyToOne(targetEntity:Chauffeurs::class)]
    #[ORM\JoinColumn(name:'idchauffeur', referencedColumnName:'IdChauffeur')]
    private $idchauffeur;

    public function getIdtransport(): ?int
    {
        return $this->idtransport;
    }

    public function getDatetrans()
    {
        return $this->datetrans;
    }

    public function setDatetrans(?\DateTimeInterface $datetrans): self
    {
        $this->datetrans = $datetrans;
        return $this;
    }

    public function getSens(): ?int
    {
        return $this->sens;
    }

    public function setSens(int $sens): self
    {
        $this->sens = $sens;
        return $this;
    }

    public function getHeuredep(): ?string
    {
        return $this->heuredep;
    }

    public function setHeuredep(string $heuredep): self
    {
        $this->heuredep = $heuredep;
        return $this;
    }

    public function getHeurearr(): ?string
    {
        return $this->heurearr;
    }

    public function setHeurearr(string $heurearr): self
    {
        $this->heurearr = $heurearr;
        return $this;
    }

    public function getNumchantierdep(): ?int
    {
        return $this->numchantierdep;
    }

    public function setNumchantierdep(int $numchantierdep): self
    {
        $this->numchantierdep = $numchantierdep;
        return $this;
    }

    public function getNumchantierarr(): ?int
    {
        return $this->numchantierarr;
    }

    public function setNumchantierarr(int $numchantierarr): self
    {
        $this->numchantierarr = $numchantierarr;
        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): self
    {
        $this->observation = $observation;
        return $this;
    }

    public function getAdressechantier(): ?string
    {
        return $this->adressechantier;
    }

    public function setAdressechantier(string $adressechantier): self
    {
        $this->adressechantier = $adressechantier;
        return $this;
    }

    public function getPoidsbon(): ?string
    {
        return $this->poidsbon;
    }

    public function setPoidsbon(string $poidsbon): self
    {
        $this->poidsbon = $poidsbon;
        return $this;
    }

    public function getPoidsbalance(): ?string
    {
        return $this->poidsbalance;
    }

    public function setPoidsbalance(string $poidsbalance): self
    {
        $this->poidsbalance = $poidsbalance;
        return $this;
    }

    public function getNbheuresprev(): ?string
    {
        return $this->nbheuresprev;
    }

    public function setNbheuresprev(string $nbheuresprev): self
    {
        $this->nbheuresprev = $nbheuresprev;
        return $this;
    }

    public function getNbheuresreal(): ?string
    {
        return $this->nbheuresreal;
    }

    public function setNbheuresreal(string $nbheuresreal): self
    {
        $this->nbheuresreal = $nbheuresreal;
        return $this;
    }

    public function getFacturetrans(): ?bool
    {
        return $this->facturetrans;
    }

    public function setFacturetrans(bool $facturetrans): self
    {
        $this->facturetrans = $facturetrans;
        return $this;
    }

    public function getEnvoifdr(): ?bool
    {
        return $this->envoifdr;
    }

    public function setEnvoifdr(bool $envoifdr): self
    {
        $this->envoifdr = $envoifdr;
        return $this;
    }

    // Continuez avec les autres getters et setters...

    public function getIdcde(): ?CdeMatEnt
    {
        return $this->idcde;
    }

    public function setIdcde(?CdeMatEnt $idcde): self
    {
        $this->idcde = $idcde;
        return $this;
    }

    public function getIdcamion(): ?Camions
    {
        return $this->idcamion;
    }

    public function setIdcamion(?Camions $idcamion): self
    {
        $this->idcamion = $idcamion;
        return $this;
    }

    public function getIdtransporteur(): ?Camions
    {
        return $this->idtransporteur;
    }

    public function setIdtransporteur(?Camions $idtransporteur): self
    {
        $this->idtransporteur = $idtransporteur;
        return $this;
    }

    public function getIdchauffeur(): ?Chauffeurs
    {
        return $this->idchauffeur;
    }

    public function setIdchauffeur(?Chauffeurs $idchauffeur): self
    {
        $this->idchauffeur = $idchauffeur;
        return $this;
    }


}
