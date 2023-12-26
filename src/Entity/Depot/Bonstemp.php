<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bonstemp
 *
 * @ORM\Table(name="bonstemp")
 * @ORM\Entity
 */
class Bonstemp
{
       
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Label", type="string", length=255, nullable=false)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="Chemin", type="text", length=0, nullable=false)
     */
    private $chemin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateTime", type="datetime", nullable=false)
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="CodeChantier", type="string", length=100, nullable=false)
     */
    private $codechantier;

    /**
     * @var string
     *
     * @ORM\Column(name="Extension", type="string", length=5, nullable=false)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeBon", type="string", length=5, nullable=false)
     */
    private $typebon;

    /**
     * @var bool
     *
     * @ORM\Column(name="Traite", type="boolean", nullable=false)
     */
    private $traite;

    /**
     * @var bool
     *
     * @ORM\Column(name="TraiteImage", type="boolean", nullable=false)
     */
    private $traiteimage;


}
