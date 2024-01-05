<?php

namespace App\Entity\Depot;

use App\Repository\Depot\TransporteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransporteurRepository::class)]
class Transporteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $idtransporteur;

    #[ORM\Column(type: 'string')]
    private $societe;
    #[ORM\Column(type: 'string')]
    private $nom;

    #[ORM\Column(type: 'string')]
    private $prenom;

    #[ORM\Column(type: 'string')]
    private $adresse;
    #[ORM\Column(type: 'string')]
    private $adresse2;

    #[ORM\Column(type: 'string')]
    private $cp;

    #[ORM\Column(type: 'string')]
    private $ville;

    #[ORM\Column(type: 'string')]
    private $tel;

    #[ORM\Column(type: 'string')]
    private $portable;

    #[ORM\Column(type: 'string')]
    private $rcs;

    #[ORM\Column(type: 'string')]
    private $rcstxt;

    #[ORM\Column(type: 'string')]
    private $ape;
    
    #[ORM\Column(type: 'string')]
    private $dombancaire;

    #[ORM\Column(type: 'string')]
    private $codebanque;

    #[ORM\Column(type: 'string')]
    private $codeguichet;

    #[ORM\Column(type: 'string')]
    private $numcompte;

    #[ORM\Column(type: 'string')]
    private $clefrib;

    #[ORM\Column(type: 'boolean')]
    private $actif;

    #[ORM\Column(type: 'string')]
    private $coderech;

    #[ORM\Column(type: 'datetime')]
    private $datemodif;

    #[ORM\Column(type: 'string')]
    private $datemodifinv;

    #[ORM\Column(type: 'boolean')]
    private $occasionnel;

    #[ORM\Column(type: 'string')]
    private $email;

    #[ORM\Column(type: 'decimal')]
    private $tauxhoraire;

    #[ORM\Column(type: 'decimal')]
    private $tauxtour;

    #[ORM\Column(type: 'decimal')]
    private $tauxjour;

    #[ORM\Column(type: 'decimal')]
    private $tauxdemijour;

    #[ORM\Column(type: 'decimal')]

    private $tauxtonne;

    #[ORM\Column(type: 'decimal')]

    private $tauxprefere;

    #[ORM\Column(type: 'string')]
    private $iban;

    public function getIdtransporteur()
    {
        return $this->idtransporteur;
    }

    public function setIdtransporteur($idtransporteur)
    {
        $this->idtransporteur = $idtransporteur;
    }

    public function getSociete()
    {
        return $this->societe;
    }

    public function setSociete($societe)
    {
        $this->societe = $societe;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    public function getAdresse2()
    {
        return $this->adresse2;
    }

    public function setAdresse2($adresse2)
    {
        $this->adresse2 = $adresse2;
    }

    public function getCp()
    {
        return $this->cp;
    }

    public function setCp($cp)
    {
        $this->cp = $cp;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    public function getPortable()
    {
        return $this->portable;
    }

    public function setPortable($portable)
    {
        $this->portable = $portable;
    }

    public function getRcs()
    {
        return $this->rcs;
    }

    public function setRcs($rcs)
    {
        $this->rcs = $rcs;
    }

    public function getRcstxt()
    {
        return $this->rcstxt;
    }

    public function setRcstxt($rcstxt)
    {
        $this->rcstxt = $rcstxt;
    }

    public function getApe()
    {
        return $this->ape;
    }

    public function setApe($ape)
    {
        $this->ape = $ape;
    }

    public function getDombancaire()
    {
        return $this->dombancaire;
    }

    public function setDombancaire($dombancaire)
    {
        $this->dombancaire = $dombancaire;
    }

    public function getCodebanque()
    {
        return $this->codebanque;
    }

    public function setCodebanque($codebanque)
    {
        $this->codebanque = $codebanque;
    }

    public function getCodeguichet()
    {
        return $this->codeguichet;
    }

    public function setCodeguichet($codeguichet)
    {
        $this->codeguichet = $codeguichet;
    }

    public function getNumcompte()
    {
        return $this->numcompte;
    }

    public function setNumcompte($numcompte)
    {
        $this->numcompte = $numcompte;
    }

    public function getClefrib()
    {
        return $this->clefrib;
    }

    public function setClefrib($clefrib)
    {
        $this->clefrib = $clefrib;
    }

    public function isActif()
    {
        return $this->actif;
    }

    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    public function getCoderech()
    {
        return $this->coderech;
    }

    public function setCoderech($coderech)
    {
        $this->coderech = $coderech;
    }

    public function getDatemodif()
    {
        return $this->datemodif;
    }

    public function setDatemodif()
    {
        $this->datemodif = new \DateTime();
    }

    public function getDatemodifinv()
    {
        return $this->datemodifinv;
    }

    public function setDatemodifinv($datemodifinv)
    {
        $this->datemodifinv = $datemodifinv;
    }

    public function isOccasionnel()
    {
        return $this->occasionnel;
    }

    public function setOccasionnel($occasionnel)
    {
        $this->occasionnel = $occasionnel;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTauxhoraire()
    {
        return $this->tauxhoraire;
    }

    public function setTauxhoraire($tauxhoraire)
    {
        $this->tauxhoraire = $tauxhoraire;
    }

    public function getTauxtour()
    {
        return $this->tauxtour;
    }

    public function setTauxtour($tauxtour)
    {
        $this->tauxtour = $tauxtour;
    }

    public function getTauxjour()
    {
        return $this->tauxjour;
    }

    public function setTauxjour($tauxjour)
    {
        $this->tauxjour = $tauxjour;
    }

    public function getTauxdemijour()
    {
        return $this->tauxdemijour;
    }

    public function setTauxdemijour($tauxdemijour)
    {
        $this->tauxdemijour = $tauxdemijour;
    }

    public function getTauxtonne()
    {
        return $this->tauxtonne;
    }

    public function setTauxtonne($tauxtonne)
    {
        $this->tauxtonne = $tauxtonne;
    }

    public function isTauxprefere()
    {
        return $this->tauxprefere;
    }

    public function setTauxprefere($tauxprefere)
    {
        $this->tauxprefere = $tauxprefere;
    }

    public function getIban()
    {
        return $this->iban;
    }

    public function setIban($iban)
    {
        $this->iban = $iban;
    }


}
