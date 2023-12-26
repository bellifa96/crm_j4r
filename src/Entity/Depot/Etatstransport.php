<?php

namespace App\Entity\Depot;

use App\Repository\Depot\EtatTransportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatTransportRepository::class)]

class Etatstransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $id;

    #[ORM\Column(type: 'string')]

    private $numaffaire;

    /**
     * @var int
     *
     * @ORM\Column(name="NumBon", type="integer", nullable=false)
     */
    private $numbon;

    #[ORM\Column(type: 'string')]

    private $typebon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateBon", type="datetime", nullable=false)
     */
    private $datebon;

    #[ORM\Column(type: 'string')]

    private $consignes;

    #[ORM\Column(type: 'integer')]

    private $numticket;


    #[ORM\Column(type: 'string')]
    private $arrivee;

    #[ORM\Column(type: 'string')]

    private $heurepesee1;

    #[ORM\Column(type: 'float')]

    private $poidspesee1;

    #[ORM\Column(type: 'integer')]

    private $basculepesee1;

    #[ORM\Column(type: 'string')]

    private $heurepesee2;

    #[ORM\Column(type: 'float')]

    private $poidspesee2;

    #[ORM\Column(type: 'integer')]

    private $basculepesee2;

    #[ORM\Column(type: 'float')]

    private $poidsmesure1;

    #[ORM\Column(type: 'float')]

    private $poidsmesure2;

    #[ORM\Column(type: 'string')]

    private $nomchauffeur;

    #[ORM\Column(type: 'string')]

    private $nomtransporteur;

    #[ORM\Column(type: 'string')]

    private $immatriculation;

    #[ORM\Column(type: 'string')]

    private $depart;

    #[ORM\Column(type: 'string')]

    private $dateboninv;


}
