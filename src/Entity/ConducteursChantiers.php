<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConducteursChantiers
 *
 * @ORM\Table(name="conducteurs_chantiers", indexes={@ORM\Index(name="id_chantier", columns={"id_chantier"})})
 * @ORM\Entity
 */
class ConducteursChantiers
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
     * @var int
     *
     * @ORM\Column(name="id_conducteur", type="integer", nullable=false)
     */
    private $idConducteur = '0';

    /**
     * @var \Chantiers
     *
     * @ORM\ManyToOne(targetEntity="Chantiers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_chantier", referencedColumnName="Idchantier")
     * })
     */
    private $idChantier;


}
