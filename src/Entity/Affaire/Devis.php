<?php

namespace App\Entity\Affaire;

use App\Entity\Demande;
use App\Entity\TimesTrait;
use App\Repository\Affaire\DevisRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
#[Gedmo\Loggable]
class Devis
{

    use TimesTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Demande::class, inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    private $demande;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $numero;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }
}
