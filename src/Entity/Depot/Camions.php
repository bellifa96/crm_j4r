<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Camions
 *
 * @ORM\Table(name="camions")
 * @ORM\Entity
 */
class Camions
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdCamion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcamion;

    /**
     * @var int
     *
     * @ORM\Column(name="IdTransporteur", type="integer", nullable=false)
     */
    private $idtransporteur;

    /**
     * @var string
     *
     * @ORM\Column(name="Immatriculation", type="string", length=20, nullable=false)
     */
    private $immatriculation;

    /**
     * @var string
     *
     * @ORM\Column(name="TonnageMax", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $tonnagemax;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeGrue", type="string", length=50, nullable=false)
     */
    private $typegrue;

    /**
     * @var string
     *
     * @ORM\Column(name="LongueurFleche", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $longueurfleche;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateVerifGrue", type="date", nullable=false)
     */
    private $dateverifgrue;

    /**
     * @var bool
     *
     * @ORM\Column(name="Actif", type="boolean", nullable=false)
     */
    private $actif;


}
