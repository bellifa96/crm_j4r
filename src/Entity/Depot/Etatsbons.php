<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etatsbons
 *
 * @ORM\Table(name="etatsbons")
 * @ORM\Entity
 */
class Etatsbons
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NumAffaire", type="string", length=100, nullable=false)
     */
    private $numaffaire;

    /**
     * @var int
     *
     * @ORM\Column(name="NumBon", type="integer", nullable=false)
     */
    private $numbon;

    /**
     * @var string
     *
     * @ORM\Column(name="DateBon", type="string", length=10, nullable=false)
     */
    private $datebon;

    /**
     * @var int
     *
     * @ORM\Column(name="Lignes", type="integer", nullable=false)
     */
    private $lignes;

    /**
     * @var float
     *
     * @ORM\Column(name="PoidsBon", type="float", precision=10, scale=2, nullable=false)
     */
    private $poidsbon;

    /**
     * @var float
     *
     * @ORM\Column(name="MontantBon", type="float", precision=10, scale=2, nullable=false)
     */
    private $montantbon;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeBon", type="string", length=255, nullable=false)
     */
    private $typebon;

    /**
     * @var string
     *
     * @ORM\Column(name="Depot", type="string", length=255, nullable=false)
     */
    private $depot;


}
