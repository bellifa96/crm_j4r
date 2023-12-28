<?php

namespace App\Entity\Depot;

use App\Repository\Depot\CamionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CamionRepository::class)]
class Camions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $idcamion;

    #[ORM\Column(type: 'integer')]
    private $idtransporteur;

    #[ORM\Column(type: 'string')]
    private $immatriculation;

    #[ORM\Column(type: 'string')]

    private $tonnagemax;

    #[ORM\Column(type: 'string')]
    private $typegrue;

    #[ORM\Column(type: 'decimal')]
    private $longueurfleche;

    #[ORM\Column(type: 'date')]
    private $dateverifgrue;

    #[ORM\Column(type: 'boolean')]
    private $actif;
    public function getIdtransporteur()
    {
        return $this->idtransporteur;
    }

    public function setIdtransporteur($idtransporteur)
    {
        $this->idtransporteur = $idtransporteur;
    }

    // Getter and Setter for $immatriculation
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    public function setImmatriculation($immatriculation)
    {
        $this->immatriculation = $immatriculation;
    }

    // Getter and Setter for $tonnagemax
    public function getTonnagemax()
    {
        return $this->tonnagemax;
    }

    public function setTonnagemax($tonnagemax)
    {
        $this->tonnagemax = $tonnagemax;
    }

    // Getter and Setter for $typegrue
    public function getTypegrue()
    {
        return $this->typegrue;
    }

    public function setTypegrue($typegrue)
    {
        $this->typegrue = $typegrue;
    }

    // Getter and Setter for $longueurfleche
    public function getLongueurfleche()
    {
        return $this->longueurfleche;
    }

    public function setLongueurfleche($longueurfleche)
    {
        $this->longueurfleche = $longueurfleche;
    }

    // Getter and Setter for $dateverifgrue
    public function getDateverifgrue()
    {
        return $this->dateverifgrue;
    }

    public function setDateverifgrue($dateverifgrue)
    {
        $this->dateverifgrue = $dateverifgrue;
    }

    // Getter and Setter for $actif
    public function getActif()
    {
        return $this->actif;
    }

    public function setActif($actif)
    {
        $this->actif = $actif;
    }


}
