<?php

namespace App\Entity\Depot;

use App\Entity\Interlocuteur\Societe;
use App\Entity\Transport\CdeMatDet;
use App\Entity\Transport\CdeMatEnt;
use App\Repository\Depot\ChantiersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * 
 * Etat Chantiers : 	
 *  0 = A démarrer 
 * 1 = En attente OS  
 * 	2 = En cours 
 * 	3 = Terminé 
 * 	4 = Annulé 
 * 	5 = A relancer 
 * 6 = Ne pas facturer 
 * 7 = Non réalisé 
 */


#[ORM\Entity(repositoryClass: ChantiersRepository::class)]

class Chantiers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    #[Groups(['chantier', 'commande'])]

    private $idchantier;

    #[ORM\Column(type: 'integer')]


    private $numchantier;

    #[ORM\Column(type: 'integer')]

    private $etat;

    #[ORM\Column(type: 'string')]

    private $ville;

    #[ORM\Column(type: 'string')]

    private $cp;

    #[ORM\Column(type: 'string')]
    private $client;

    #[ORM\Column(type: 'string')]
    private $nomchantier;

    #[ORM\Column(type: 'string')]
    private $voie;

    #[ORM\Column(type: 'string')]
    private $adresse;

    #[ORM\ManyToOne(targetEntity: Agence::class, inversedBy: 'chantiers')]
    #[ORM\JoinColumn(name: 'idagence', referencedColumnName: 'idagence')]
    private $idagence;

    #[ORM\OneToMany(targetEntity: CdeMatEnt::class, mappedBy: 'id_chantier')]

    private  $commandes;

    #[ORM\ManyToOne(targetEntity: Societe::class, inversedBy: 'chantiers')]
    #[ORM\JoinColumn(name: 'id_client', referencedColumnName: 'id')]
    private $id_client;


    #[ORM\OneToMany(targetEntity: Chantiers::class, mappedBy: 'numchantierdepart')]

    private  $numchantierdepart;

    #[ORM\OneToMany(targetEntity: Chantiers::class, mappedBy: 'numchantierarrive')]

    private  $numchantierarrive;

    public function __construct() {
        $this->numchantierdepart = new ArrayCollection();
        $this->numchantierarrive = new ArrayCollection();
    }
    public function getNumChantierDepart() {
        return $this->numchantierdepart;
    }

    public function setNumChantierDepart($numchantierdepart) {
        $this->numchantierdepart = $numchantierdepart;
    }

    // Getter and setter for numchantierarrive
    public function getNumChantierArrive() {
        return $this->numchantierarrive;
    }

    public function setNumChantierArrive($numchantierarrive) {
        $this->numchantierarrive = $numchantierarrive;
    }

    public function getIdClient()
    {
        return $this->id_client;
    }

    // Setter method for id_client
    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;
    }





    public function getCommandes()
    {
        return $this->commandes;
    }

    // Setter method for the commandes property
    public function setCommandes( $commandes): void
    {
        $this->commandes = $commandes;
    }

    public function getIdChantier(): ?int
    {
        return $this->idchantier;
    }

    public function setIdChantier(int $idchantier): void
    {
        $this->idchantier = $idchantier;
    }



    public function getNumChantier(): ?int
    {
        return $this->numchantier;
    }

    public function setNumChantier(int $numchantier): void
    {
        $this->numchantier = $numchantier;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): void
    {
        $this->cp = $cp;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): void
    {
        $this->client = $client;
    }

    public function getNomChantier(): ?string
    {
        return $this->nomchantier;
    }

    public function setNomChantier(string $nomchantier): void
    {
        $this->nomchantier = $nomchantier;
    }

    public function getVoie(): ?string
    {
        return $this->voie;
    }

    public function setVoie(string $voie): void
    {
        $this->voie = $voie;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getIdAgence(): ?Agence
    {
        return $this->idagence;
    }

    public function setIdAgence(?Agence $idagence): void
    {
        $this->idagence = $idagence;
    }
    public function __toString() {
        return $this->nomchantier;
    }
}
