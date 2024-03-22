<?php

namespace App\Entity\Depot;

use App\Entity\Depot\Camions;
use App\Entity\Depot\Chauffeurs;
use App\Entity\Transport\CdeMatEnt;
use App\Repository\Affaire\TransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TransportRepository::class)]
#[ORM\Table(name: "transports")]
class Transports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $idtransport;

    

    #[ORM\Column(type: 'integer')]
    private $typeTransport = '0';

    #[ORM\Column(type: 'string')]

    private $heuredepart = 'NULL';

    #[ORM\Column(type: 'string')]

    private $heurearrive = 'NULL';

    


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

    private $datesaisie;

    #[ORM\Column(type: 'date')]

    private $dateTransport;

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

    #[ORM\Column(type: 'integer')]
    private $typeEnlevement = '0';

    #[ORM\Column(type: 'integer')]

    private $volume = '0';

    #[ORM\Column(type: 'integer')]

    private $creationAffectation = '0';


    #[ORM\Column(type: 'string')]

    private $eventTransportId = '';

     
    #[ORM\ManyToOne(targetEntity:Chantiers::class)]
    #[ORM\JoinColumn(name:'numchantierdepart', referencedColumnName:'idchantier')]
    private $numchantierdepart ;

    #[ORM\ManyToOne(targetEntity:Chantiers::class)]
    #[ORM\JoinColumn(name:'numchantierarrive', referencedColumnName:'idchantier')]

    private $numchantierarrive ;
 
    #[ORM\ManyToOne(targetEntity:CdeMatEnt::class)]
    #[ORM\JoinColumn(name:'idcde', referencedColumnName:'id')]
    private $idcde;

    
    #[ORM\ManyToOne(targetEntity:Camions::class)]
    #[ORM\JoinColumn(name:'idcamion', referencedColumnName:'idcamion')]
    private $idcamion;

    #[ORM\ManyToOne(targetEntity:Transporteur::class)]
    #[ORM\JoinColumn(name:'idtransporteur', referencedColumnName:'idtransporteur')]
    private $idtransporteur;

   
    #[ORM\ManyToOne(targetEntity:Chauffeurs::class)]
    #[ORM\JoinColumn(name:'idchauffeur', referencedColumnName:'idchauffeur')]
    private $idchauffeur;

    public function getEventTransportId(): string {
        return $this->eventTransportId;
    }

    // Setter
    public function setEventTransportId(string $eventTransportId): void {
        $this->eventTransportId = $eventTransportId;
    }
    
    public function getDateTransport(): ?\DateTimeInterface
    {
        return $this->dateTransport;
    }

    // Setter
    public function setDateTransport(\DateTimeInterface $dateTransport): self
    {
        $this->dateTransport = $dateTransport;

        return $this;
    }

    

    public function getIdtransport(): ?int
    {
        return $this->idtransport;
    }

   
    public function getTypeTransport(): ?int
    {
        return $this->typeTransport;
    }

    public function setTypeTransport(int $typeTransport): self
    {
        $this->typeTransport = $typeTransport;
        return $this;
    }

    public function getcreationAffectation(): ?int
    {
        return $this->creationAffectation;
    }

    public function setcreationAffectation(int $creationAffectation): self
    {
        $this->creationAffectation = $creationAffectation;
        return $this;
    }
    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): self
    {
        $this->volume = $volume;
        return $this;
    }

    public function getHeuredepart(): ?string
    {
        return $this->heuredepart;
    }

    public function setHeuredepart(string $heuredepart): self
    {
        $this->heuredepart = $heuredepart;
        return $this;
    }

    public function getHeurearr(): ?string
    {
        return $this->heurearrive;
    }

    public function setHeurearrive(string $heurearrive): self
    {
        $this->heurearrive = $heurearrive;
        return $this;
    }

    public function getNumchantierdep() 
    {
        return $this->numchantierdepart;
    }

    public function setNumchantierdep(Chantiers $numchantierdepart): self
    {
        $this->numchantierdepart = $numchantierdepart;
        return $this;
    }

    public function getNumchantierarrive()
    {
        return $this->numchantierarrive;
    }

    public function setNumchantierarr(Chantiers $numchantierarrive): self
    {
        $this->numchantierarrive = $numchantierarrive;
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

    public function getIdtransporteur(): ?Transporteur
    {
        return $this->idtransporteur;
    }

    public function setIdtransporteur(?Transporteur $idtransporteur): self
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
  
    public function getHeuredep2(): ?string {
        return $this->heuredep2;
    }

    public function setHeuredep2(?string $heuredep2): void {
        $this->heuredep2 = $heuredep2;
    }

    public function getHeurearr2(): ?string {
        return $this->heurearr2;
    }

    public function setHeurearr2(?string $heurearr2): void {
        $this->heurearr2 = $heurearr2;
    }

    public function getDatesaisie() {
        return $this->datesaisie;
    }

    public function setDatesaisie($datesaisie): void {
        $this->datesaisie = $datesaisie;
    }

    public function getTauxPrefere(): ?string {
        return $this->tauxPrefere;
    }

    public function setTauxPrefere(?string $tauxPrefere): void {
        $this->tauxPrefere = $tauxPrefere;
    }

    public function getMontant(): ?string {
        return $this->montant;
    }

    public function setMontant(?string $montant): void {
        $this->montant = $montant;
    }

    public function getLitige(): ?string {
        return $this->litige;
    }

    public function setLitige(?string $litige): void {
        $this->litige = $litige;
    }

    public function getMotiflitige(): ?string {
        return $this->motiflitige;
    }

    public function setMotiflitige(?string $motiflitige): void {
        $this->motiflitige = $motiflitige;
    }

    public function getAnnulationtrans(): ?string {
        return $this->annulationtrans;
    }

    public function setAnnulationtrans(?string $annulationtrans): void {
        $this->annulationtrans = $annulationtrans;
    }

    public function getMotifannulation(): ?string {
        return $this->motifannulation;
    }

    public function setMotifannulation(?string $motifannulation): void {
        $this->motifannulation = $motifannulation;
    }

    public function getGroupagecamion(): ?string {
        return $this->groupagecamion;
    }

    public function setGroupagecamion(?string $groupagecamion): void {
        $this->groupagecamion = $groupagecamion;
    }

    public function getEnvoiannulemail(): ?string {
        return $this->envoiannulemail;
    }

    public function setEnvoiannulemail(?string $envoiannulemail): void {
        $this->envoiannulemail = $envoiannulemail;
    }
    public function getTypeEnlevement(): ?int {
        return $this->typeEnlevement;
    }

    public function setTypeEnlevement(?int $typeEnlevement): void {
        $this->typeEnlevement = $typeEnlevement;
    }

}
