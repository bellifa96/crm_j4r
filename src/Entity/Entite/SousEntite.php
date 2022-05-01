<?php

namespace App\Entity\Entite;

use App\Entity\AdresseTrait;
use App\Entity\TimesTrait;
use App\Repository\Entite\SousEntiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousEntiteRepository::class)]
class SousEntite
{
    use TimesTrait;
    use AdresseTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $raisonSociale;

    #[ORM\Column(type: 'string', length: 255)]
    private $siret;

    #[ORM\Column(type: 'string', length: 255)]
    private $dirigeant;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateDeCreation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $formeJuridique;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $activitePrincipale;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\OneToOne(mappedBy: 'sousEntite', targetEntity: Depot::class, cascade: ['persist', 'remove'])]
    private $depot;

    #[ORM\ManyToOne(targetEntity: Entite::class, inversedBy: 'sousEntites')]
    private $entite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getDirigeant(): ?string
    {
        return $this->dirigeant;
    }

    public function setDirigeant(string $dirigeant): self
    {
        $this->dirigeant = $dirigeant;

        return $this;
    }

    public function getDateDeCreation(): ?string
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation(?string $dateDeCreation): self
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    public function getFormeJuridique(): ?string
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(?string $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getActivitePrincipale(): ?string
    {
        return $this->activitePrincipale;
    }

    public function setActivitePrincipale(?string $activitePrincipale): self
    {
        $this->activitePrincipale = $activitePrincipale;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDepot(): ?Depot
    {
        return $this->depot;
    }

    public function setDepot(Depot $depot): self
    {
        // set the owning side of the relation if necessary
        if ($depot->getSousEntite() !== $this) {
            $depot->setSousEntite($this);
        }

        $this->depot = $depot;

        return $this;
    }

    public function getEntite(): ?Entite
    {
        return $this->entite;
    }

    public function setEntite(?Entite $entite): self
    {
        $this->entite = $entite;

        return $this;
    }
}
