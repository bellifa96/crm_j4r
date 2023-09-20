<?php

namespace App\Entity\Interlocuteur;

use App\Entity\AdresseTrait;
use App\Repository\Interlocuteur\SocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

#[UniqueEntity(fields: ['siret'], message: 'There is already an society with this siret')]
#[Gedmo\Loggable]
#[ORM\Entity(repositoryClass: SocieteRepository::class)]
class Societe
{
    use AdresseTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $raisonSociale;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $siret;


    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $formeJuridique;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lienSocieteCom;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dirigeant;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateDeCreation;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $email;

    #[ORM\OneToOne(mappedBy: 'societe', targetEntity: Interlocuteur::class, cascade: ['persist', 'remove'])]
    private $interlocuteur;

    #[ORM\Column(type: 'string', length: 255)]
    private $siren;

    #[ORM\ManyToOne(targetEntity: Activite::class, inversedBy: 'societes')]
    private $activitePrincipale;

    #[ORM\ManyToMany(targetEntity: Activite::class, inversedBy: 'societesSecondaires')]
    private $activitesSecondaires;

    public function __construct()
    {
        $this->activitesSecondaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

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


    public function getFormeJuridique(): ?string
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(?string $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getLienSocieteCom(): ?string
    {
        return $this->lienSocieteCom;
    }

    public function setLienSocieteCom(?string $lienSocieteCom): self
    {
        $this->lienSocieteCom = $lienSocieteCom;

        return $this;
    }

    public function getDirigeant(): ?string
    {
        return $this->dirigeant;
    }

    public function setDirigeant(?string $dirigeant): self
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getInterlocuteur(): ?Interlocuteur
    {
        return $this->interlocuteur;
    }

    public function setInterlocuteur(?Interlocuteur $interlocuteur): self
    {
        // unset the owning side of the relation if necessary
        if ($interlocuteur === null && $this->interlocuteur !== null) {
            $this->interlocuteur->setSociete(null);
        }

        // set the owning side of the relation if necessary
        if ($interlocuteur !== null && $interlocuteur->getSociete() !== $this) {
            $interlocuteur->setSociete($this);
        }

        $this->interlocuteur = $interlocuteur;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getActivitePrincipale(): ?Activite
    {
        return $this->activitePrincipale;
    }

    public function setActivitePrincipale(?Activite $activitePrincipale): self
    {
        $this->activitePrincipale = $activitePrincipale;

        return $this;
    }

    /**
     * @return Collection<int, Activite>
     */
    public function getActivitesSecondaires(): Collection
    {
        return $this->activitesSecondaires;
    }

    public function addActivitesSecondaire(Activite $activitesSecondaire): self
    {
        if (!$this->activitesSecondaires->contains($activitesSecondaire)) {
            $this->activitesSecondaires[] = $activitesSecondaire;
        }

        return $this;
    }

    public function removeActivitesSecondaire(Activite $activitesSecondaire): self
    {
        $this->activitesSecondaires->removeElement($activitesSecondaire);

        return $this;
    }

}
