<?php

namespace App\Entity;

use App\Entity\Affaire\Devis;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Entity(repositoryClass: DemandeRepository::class)]
#[Gedmo\Loggable]
class Demande
{
    use AdresseTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'demandes')]
    private $client;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'demandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $createur;


    #[Gedmo\Versioned]
    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $nomChantier;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $date;

    #[Gedmo\Versioned]
    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'demandesIntermediaire')]
    private $intermediaire;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $typeDePrestation;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $documentsSouhaites;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'boolean')]
    private $fondsDePlan;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $classeDEchaffaudage;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $typeDeMateriel;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float')]
    private $dimensionsGlobales;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $ammarages;

    #[ORM\OneToMany(mappedBy: 'demande', targetEntity: Devis::class)]
    private $devis;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array')]
    private $travauxPrevus = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float')]
    private $largeurDeTravail;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float')]
    private $consoles;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $equipements;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $acces;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float')]
    private $porteeLibre;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float')]
    private $longueur;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $traitementDesPignons;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $finitionPlancher;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $gcPeripherique;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeEchafaudage;

    #[ORM\Column(type: 'array')]
    private $dimensions = [];

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Interlocuteur
    {
        return $this->client;
    }

    public function setClient(?Interlocuteur $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNomChantier(): ?string
    {
        return $this->nomChantier;
    }

    public function setNomChantier(string $nomChantier): self
    {
        $this->nomChantier = $nomChantier;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIntermediaire(): ?Interlocuteur
    {
        return $this->intermediaire;
    }

    public function setIntermediaire(?Interlocuteur $intermediaire): self
    {
        $this->intermediaire = $intermediaire;

        return $this;
    }

    public function getTypeDePrestation(): ?string
    {
        return $this->typeDePrestation;
    }

    public function setTypeDePrestation(string $typeDePrestation): self
    {
        $this->typeDePrestation = $typeDePrestation;

        return $this;
    }

    public function getDocumentsSouhaites(): ?string
    {
        return $this->documentsSouhaites;
    }

    public function setDocumentsSouhaites(string $documentsSouhaites): self
    {
        $this->documentsSouhaites = $documentsSouhaites;

        return $this;
    }

    public function getFondsDePlan(): ?bool
    {
        return $this->fondsDePlan;
    }

    public function setFondsDePlan(bool $fondsDePlan): self
    {
        $this->fondsDePlan = $fondsDePlan;

        return $this;
    }


    public function getClasseDEchaffaudage(): ?string
    {
        return $this->classeDEchaffaudage;
    }

    public function setClasseDEchaffaudage(string $classeDEchaffaudage): self
    {
        $this->classeDEchaffaudage = $classeDEchaffaudage;

        return $this;
    }

    public function getTypeDeMateriel(): ?string
    {
        return $this->typeDeMateriel;
    }

    public function setTypeDeMateriel(string $typeDeMateriel): self
    {
        $this->typeDeMateriel = $typeDeMateriel;

        return $this;
    }

    public function getDimensionsGlobales(): ?float
    {
        return $this->dimensionsGlobales;
    }

    public function setDimensionsGlobales(float $dimensionsGlobales): self
    {
        $this->dimensionsGlobales = $dimensionsGlobales;

        return $this;
    }

    public function getAmmarages(): ?string
    {
        return $this->ammarages;
    }

    public function setAmmarages(string $ammarages): self
    {
        $this->ammarages = $ammarages;

        return $this;
    }

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): self
    {
        if (!$this->devis->contains($devi)) {
            $this->devis[] = $devi;
            $devi->setDemande($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getDemande() === $this) {
                $devi->setDemande(null);
            }
        }

        return $this;
    }

    public function getTravauxPrevus(): ?array
    {
        return $this->travauxPrevus;
    }

    public function setTravauxPrevus(array $travauxPrevus): self
    {
        $this->travauxPrevus = $travauxPrevus;

        return $this;
    }

    public function getLargeurDeTravail(): ?float
    {
        return $this->largeurDeTravail;
    }

    public function setLargeurDeTravail(float $largeurDeTravail): self
    {
        $this->largeurDeTravail = $largeurDeTravail;

        return $this;
    }

    public function getConsoles(): ?float
    {
        return $this->consoles;
    }

    public function setConsoles(float $consoles): self
    {
        $this->consoles = $consoles;

        return $this;
    }

    public function getEquipements(): ?string
    {
        return $this->equipements;
    }

    public function setEquipements(string $equipements): self
    {
        $this->equipements = $equipements;

        return $this;
    }

    public function getAcces(): ?string
    {
        return $this->acces;
    }

    public function setAcces(string $acces): self
    {
        $this->acces = $acces;

        return $this;
    }

    public function getPorteeLibre(): ?float
    {
        return $this->porteeLibre;
    }

    public function setPorteeLibre(float $porteeLibre): self
    {
        $this->porteeLibre = $porteeLibre;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getTraitementDesPignons(): ?string
    {
        return $this->traitementDesPignons;
    }

    public function setTraitementDesPignons(string $traitementDesPignons): self
    {
        $this->traitementDesPignons = $traitementDesPignons;

        return $this;
    }

    public function getFinitionPlancher(): ?string
    {
        return $this->finitionPlancher;
    }

    public function setFinitionPlancher(string $finitionPlancher): self
    {
        $this->finitionPlancher = $finitionPlancher;

        return $this;
    }

    public function getGcPeripherique(): ?string
    {
        return $this->gcPeripherique;
    }

    public function setGcPeripherique(string $gcPeripherique): self
    {
        $this->gcPeripherique = $gcPeripherique;

        return $this;
    }

    public function getTypeEchafaudage(): ?string
    {
        return $this->typeEchafaudage;
    }

    public function setTypeEchafaudage(string $typeEchafaudage): self
    {
        $this->typeEchafaudage = $typeEchafaudage;
        return $this;
    }

    public function getDimensions(): ?array
    {
        return $this->dimensions;
    }

    public function setDimensions(array $dimensions): self
    {
        $this->dimensions = $dimensions;
        return $this;
    }
}
