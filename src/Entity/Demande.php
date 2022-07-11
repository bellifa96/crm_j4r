<?php

namespace App\Entity;

use App\Entity\Affaire\Devis;
use App\Entity\Affaire\Evenement;
use App\Entity\Affaire\Transport;
use App\Entity\Contact\Contact;
use App\Entity\Conversation\ConversationApresNegociationDemande;
use App\Entity\Conversation\ConversationClient;
use App\Entity\Conversation\ConversationMetreDemande;
use App\Entity\Ged\Fichier;
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
    use TimesTrait;

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
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $typeDePrestation;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'boolean', nullable: true)]
    private $fondsDePlan;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $classeDEchaffaudage;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $typeDeMateriel;

    #[ORM\OneToMany(mappedBy: 'demande', targetEntity: Devis::class)]
    private $devis;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array')]
    private $travauxPrevus = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $largeurDeTravail;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true,)]
    private $consoles;


    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $acces;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float', nullable: true)]
    private $porteeLibre;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'float', nullable: true)]
    private $longueur;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $traitementDesPignons;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $finitionPlancher;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gcPeripherique;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $typeEchafaudage;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array')]
    private $dimensions = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $distanceALaFacade;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $rapportDistanceALaFacade;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array', nullable: true)]
    private $hauteurDesPlanchers = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $largeurPassagePieton;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $protectionCouvreur;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array', nullable: true)]
    private $bacheEtFilet = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array', nullable: true)]
    private $documentsSouhaites = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array', nullable: true)]
    private $ammarages = [];

    #[Gedmo\Versioned]
    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'demandes')]
    private $contactPrincipalClient;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array', nullable: true)]
    private $equipements = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array', nullable: true)]
    private $bache = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array', nullable: true)]
    private $dimensionsGlobales = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $statut;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $statutCommercial;

    #[ORM\OneToMany(mappedBy: 'demande', targetEntity: Evenement::class)]
    private $evenements;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'demandesMaitreDOuvrage')]
    private $maitreDOuvrage;

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'demandesContactPrincipalMaitreDOuvrage')]
    private $contactPrincipalMaitreDOuvrage;

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'demandesContactPrincipalIntermediaire')]
    private $contactPrincipalIntermediaire;

    #[ORM\OneToMany(mappedBy: 'contactsSecondaires', targetEntity: Contact::class)]
    private $contactsSecondaires;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'array', nullable: true)]
    private $hauteur = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaireMetre;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaireApresNegociation;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaireClients;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateDuReleve;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateDeRemise;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateDeValidationDirection;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $DateEnvoieClient;

    #[ORM\OneToMany(mappedBy: 'demande', targetEntity: Fichier::class)]
    private $ged;

    #[ORM\OneToOne(mappedBy: 'demande', targetEntity: ConversationMetreDemande::class, cascade: ['persist', 'remove'])]
    private $conversationMetreDemande;

    #[ORM\OneToOne(mappedBy: 'demande', targetEntity: ConversationApresNegociationDemande::class, cascade: ['persist', 'remove'])]
    private $conversationApresNegociationDemande;

    #[ORM\OneToOne(mappedBy: 'demande', targetEntity: ConversationClient::class, cascade: ['persist', 'remove'])]
    private $conversationClient;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $reference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $neufReno;

    #[ORM\Column(type: 'array', nullable: true)]
    private $menu = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gardeCorps;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $typeDeMontage;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $utilisationDuMatériel;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Implantation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cantonnement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $zoneDeStockage;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $manutentionSupplementaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $materielAPrevoir;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $structureEchafaudage;

    #[ORM\OneToOne(mappedBy: 'chantier', targetEntity: Transport::class, cascade: ['persist', 'remove'])]
    private $transport;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
        $this->statut = "A transmettre";
        $this->evenements = new ArrayCollection();
        $this->contactsSecondaires = new ArrayCollection();
        $this->ged = new ArrayCollection();
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

    public function setTypeDePrestation(?string $typeDePrestation): self
    {
        $this->typeDePrestation = $typeDePrestation;

        return $this;
    }

    public function getFondsDePlan(): ?bool
    {
        return $this->fondsDePlan;
    }

    public function setFondsDePlan(?bool $fondsDePlan): self
    {
        $this->fondsDePlan = $fondsDePlan;

        return $this;
    }


    public function getClasseDEchaffaudage(): ?string
    {
        return $this->classeDEchaffaudage;
    }

    public function setClasseDEchaffaudage(?string $classeDEchaffaudage): self
    {
        $this->classeDEchaffaudage = $classeDEchaffaudage;

        return $this;
    }

    public function getTypeDeMateriel(): ?string
    {
        return $this->typeDeMateriel;
    }

    public function setTypeDeMateriel(?string $typeDeMateriel): self
    {
        $this->typeDeMateriel = $typeDeMateriel;

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

    public function getLargeurDeTravail(): ?string
    {
        return $this->largeurDeTravail;
    }

    public function setLargeurDeTravail(?string $largeurDeTravail): self
    {
        $this->largeurDeTravail = $largeurDeTravail;

        return $this;
    }

    public function getConsoles(): ?string
    {
        return $this->consoles;
    }

    public function setConsoles(?string $consoles): self
    {
        $this->consoles = $consoles;

        return $this;
    }

    public function getAcces(): ?string
    {
        return $this->acces;
    }

    public function setAcces(?string $acces): self
    {
        $this->acces = $acces;

        return $this;
    }

    public function getPorteeLibre(): ?float
    {
        return $this->porteeLibre;
    }

    public function setPorteeLibre(?float $porteeLibre): self
    {
        $this->porteeLibre = $porteeLibre;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(?float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getTraitementDesPignons(): ?string
    {
        return $this->traitementDesPignons;
    }

    public function setTraitementDesPignons(?string $traitementDesPignons): self
    {
        $this->traitementDesPignons = $traitementDesPignons;

        return $this;
    }

    public function getFinitionPlancher(): ?string
    {
        return $this->finitionPlancher;
    }

    public function setFinitionPlancher(?string $finitionPlancher): self
    {
        $this->finitionPlancher = $finitionPlancher;

        return $this;
    }

    public function getGcPeripherique(): ?string
    {
        return $this->gcPeripherique;
    }

    public function setGcPeripherique(?string $gcPeripherique): self
    {
        $this->gcPeripherique = $gcPeripherique;

        return $this;
    }

    public function getTypeEchafaudage(): ?string
    {
        return $this->typeEchafaudage;
    }

    public function setTypeEchafaudage(?string $typeEchafaudage): self
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

    public function getDistanceALaFacade(): ?string
    {
        return $this->distanceALaFacade;
    }

    public function setDistanceALaFacade(?string $distanceALaFacade): self
    {
        $this->distanceALaFacade = $distanceALaFacade;

        return $this;
    }

    public function getRapportDistanceALaFacade(): ?string
    {
        return $this->rapportDistanceALaFacade;
    }

    public function setRapportDistanceALaFacade(?string $rapportDistanceALaFacade): self
    {
        $this->rapportDistanceALaFacade = $rapportDistanceALaFacade;

        return $this;
    }

    public function getHauteurDesPlanchers(): ?array
    {
        return $this->hauteurDesPlanchers;
    }

    public function setHauteurDesPlanchers(?array $hauteurDesPlanchers): self
    {
        $this->hauteurDesPlanchers = $hauteurDesPlanchers;

        return $this;
    }

    public function getLargeurPassagePieton(): ?string
    {
        return $this->largeurPassagePieton;
    }

    public function setLargeurPassagePieton(?string $largeurPassagePieton): self
    {
        $this->largeurPassagePieton = $largeurPassagePieton;

        return $this;
    }

    public function getProtectionCouvreur(): ?string
    {
        return $this->protectionCouvreur;
    }

    public function setProtectionCouvreur(?string $protectionCouvreur): self
    {
        $this->protectionCouvreur = $protectionCouvreur;

        return $this;
    }

    public function getBacheEtFilet(): ?array
    {
        return $this->bacheEtFilet;
    }

    public function setBacheEtFilet(?array $bacheEtFilet): self
    {
        $this->bacheEtFilet = $bacheEtFilet;

        return $this;
    }

    public function getDocumentsSouhaites(): ?array
    {
        return $this->documentsSouhaites;
    }

    public function setDocumentsSouhaites(?array $documentsSouhaites): self
    {
        $this->documentsSouhaites = $documentsSouhaites;

        return $this;
    }

    public function getAmmarages(): ?array
    {
        return $this->ammarages;
    }

    public function setAmmarages(?array $ammarages): self
    {
        $this->ammarages = $ammarages;

        return $this;
    }

    public function getContactPrincipalClient(): ?Contact
    {
        return $this->contactPrincipalClient;
    }

    public function setContactPrincipalClient(?Contact $contactPrincipalClient): self
    {
        $this->contactPrincipalClient = $contactPrincipalClient;

        return $this;
    }

    public function getEquipements(): ?array
    {
        return $this->equipements;
    }

    public function setEquipements(?array $equipements): self
    {
        $this->equipements = $equipements;

        return $this;
    }

    public function getBache(): ?array
    {
        return $this->bache;
    }

    public function setBache(?array $bache): self
    {
        $this->bache = $bache;

        return $this;
    }

    public function getDimensionsGlobales(): ?array
    {
        return $this->dimensionsGlobales;
    }

    public function setDimensionsGlobales(?array $dimensionsGlobales): self
    {
        $this->dimensionsGlobales = $dimensionsGlobales;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getStatutCommercial(): ?string
    {
        return $this->statutCommercial;
    }

    public function setStatutCommercial(?string $statutCommercial): self
    {
        $this->statutCommercial = $statutCommercial;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setDemande($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getDemande() === $this) {
                $evenement->setDemande(null);
            }
        }

        return $this;
    }

    public function getMaitreDOuvrage(): ?Interlocuteur
    {
        return $this->maitreDOuvrage;
    }

    public function setMaitreDOuvrage(?Interlocuteur $maitreDOuvrage): self
    {
        $this->maitreDOuvrage = $maitreDOuvrage;

        return $this;
    }

    public function getContactPrincipalMaitreDOuvrage(): ?Contact
    {
        return $this->contactPrincipalMaitreDOuvrage;
    }

    public function setContactPrincipalMaitreDOuvrage(?Contact $contactPrincipalMaitreDOuvrage): self
    {
        $this->contactPrincipalMaitreDOuvrage = $contactPrincipalMaitreDOuvrage;

        return $this;
    }

    public function getContactPrincipalIntermediaire(): ?Contact
    {
        return $this->contactPrincipalIntermediaire;
    }

    public function setContactPrincipalIntermediaire(?Contact $contactPrincipalIntermediaire): self
    {
        $this->contactPrincipalIntermediaire = $contactPrincipalIntermediaire;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContactsSecondaires(): Collection
    {
        return $this->contactsSecondaires;
    }

    public function addContactsSecondaire(Contact $contactsSecondaire): self
    {
        if (!$this->contactsSecondaires->contains($contactsSecondaire)) {
            $this->contactsSecondaires[] = $contactsSecondaire;
            $contactsSecondaire->setContactsSecondaires($this);
        }

        return $this;
    }

    public function removeContactsSecondaire(Contact $contactsSecondaire): self
    {
        if ($this->contactsSecondaires->removeElement($contactsSecondaire)) {
            // set the owning side to null (unless already changed)
            if ($contactsSecondaire->getContactsSecondaires() === $this) {
                $contactsSecondaire->setContactsSecondaires(null);
            }
        }

        return $this;
    }

    public function getHauteur(): ?array
    {
        return $this->hauteur;
    }

    public function setHauteur(?array $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getCommentaireMetre(): ?string
    {
        return $this->commentaireMetre;
    }

    public function setCommentaireMetre(?string $commentaireMetre): self
    {
        $this->commentaireMetre = $commentaireMetre;

        return $this;
    }

    public function getCommentaireApresNegociation(): ?string
    {
        return $this->commentaireApresNegociation;
    }

    public function setCommentaireApresNegociation(?string $commentaireApresNegociation): self
    {
        $this->commentaireApresNegociation = $commentaireApresNegociation;

        return $this;
    }

    public function getCommentaireClients(): ?string
    {
        return $this->commentaireClients;
    }

    public function setCommentaireClients(?string $commentaireClients): self
    {
        $this->commentaireClients = $commentaireClients;

        return $this;
    }

    public function getDateDuReleve(): ?string
    {
        return $this->dateDuReleve;
    }

    public function setDateDuReleve(?string $dateDuReleve): self
    {
        $this->dateDuReleve = $dateDuReleve;

        return $this;
    }

    public function getDateDeRemise(): ?string
    {
        return $this->dateDeRemise;
    }

    public function setDateDeRemise(?string $dateDeRemise): self
    {
        $this->dateDeRemise = $dateDeRemise;

        return $this;
    }

    public function getDateDeValidationDirection(): ?\DateTimeInterface
    {
        return $this->dateDeValidationDirection;
    }

    public function setDateDeValidationDirection(?\DateTimeInterface $dateDeValidationDirection): self
    {
        $this->dateDeValidationDirection = $dateDeValidationDirection;

        return $this;
    }

    public function getDateEnvoieClient(): ?\DateTimeInterface
    {
        return $this->DateEnvoieClient;
    }

    public function setDateEnvoieClient(?\DateTimeInterface $DateEnvoieClient): self
    {
        $this->DateEnvoieClient = $DateEnvoieClient;

        return $this;
    }

    /**
     * @return Collection<int, Fichier>
     */
    public function getGed(): Collection
    {
        return $this->ged;
    }

    public function addGed(Fichier $ged): self
    {
        if (!$this->ged->contains($ged)) {
            $this->ged[] = $ged;
            $ged->setDemande($this);
        }

        return $this;
    }

    public function removeGed(Fichier $ged): self
    {
        if ($this->ged->removeElement($ged)) {
            // set the owning side to null (unless already changed)
            if ($ged->getDemande() === $this) {
                $ged->setDemande(null);
            }
        }

        return $this;
    }

    public function getConversationMetreDemande(): ?ConversationMetreDemande
    {
        return $this->conversationMetreDemande;
    }

    public function setConversationMetreDemande(?ConversationMetreDemande $conversationMetreDemande): self
    {
        // unset the owning side of the relation if necessary
        if ($conversationMetreDemande === null && $this->conversationMetreDemande !== null) {
            $this->conversationMetreDemande->setDemande(null);
        }

        // set the owning side of the relation if necessary
        if ($conversationMetreDemande !== null && $conversationMetreDemande->getDemande() !== $this) {
            $conversationMetreDemande->setDemande($this);
        }

        $this->conversationMetreDemande = $conversationMetreDemande;

        return $this;
    }

    public function getConversationApresNegociationDemande(): ?ConversationApresNegociationDemande
    {
        return $this->conversationApresNegociationDemande;
    }

    public function setConversationApresNegociationDemande(?ConversationApresNegociationDemande $conversationApresNegociationDemande): self
    {
        // unset the owning side of the relation if necessary
        if ($conversationApresNegociationDemande === null && $this->conversationApresNegociationDemande !== null) {
            $this->conversationApresNegociationDemande->setDemande(null);
        }

        // set the owning side of the relation if necessary
        if ($conversationApresNegociationDemande !== null && $conversationApresNegociationDemande->getDemande() !== $this) {
            $conversationApresNegociationDemande->setDemande($this);
        }

        $this->conversationApresNegociationDemande = $conversationApresNegociationDemande;

        return $this;
    }

    public function getConversationClient(): ?ConversationClient
    {
        return $this->conversationClient;
    }

    public function setConversationClient(?ConversationClient $conversationClient): self
    {
        // unset the owning side of the relation if necessary
        if ($conversationClient === null && $this->conversationClient !== null) {
            $this->conversationClient->setDemande(null);
        }

        // set the owning side of the relation if necessary
        if ($conversationClient !== null && $conversationClient->getDemande() !== $this) {
            $conversationClient->setDemande($this);
        }

        $this->conversationClient = $conversationClient;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNeufReno(): ?string
    {
        return $this->neufReno;
    }

    public function setNeufReno(?string $neufReno): self
    {
        $this->neufReno = $neufReno;

        return $this;
    }

    public function getMenu(): ?array
    {
        return $this->menu;
    }

    public function setMenu(?array $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getGardeCorps(): ?string
    {
        return $this->gardeCorps;
    }

    public function setGardeCorps(?string $gardeCorps): self
    {
        $this->gardeCorps = $gardeCorps;

        return $this;
    }

    public function getTypeDeMontage(): ?string
    {
        return $this->typeDeMontage;
    }

    public function setTypeDeMontage(?string $typeDeMontage): self
    {
        $this->typeDeMontage = $typeDeMontage;

        return $this;
    }

    public function getUtilisationDuMatériel(): ?string
    {
        return $this->utilisationDuMatériel;
    }

    public function setUtilisationDuMatériel(?string $utilisationDuMatériel): self
    {
        $this->utilisationDuMatériel = $utilisationDuMatériel;

        return $this;
    }

    public function getImplantation(): ?string
    {
        return $this->Implantation;
    }

    public function setImplantation(?string $Implantation): self
    {
        $this->Implantation = $Implantation;

        return $this;
    }

    public function getCantonnement(): ?string
    {
        return $this->cantonnement;
    }

    public function setCantonnement(?string $cantonnement): self
    {
        $this->cantonnement = $cantonnement;

        return $this;
    }

    public function getZoneDeStockage(): ?string
    {
        return $this->zoneDeStockage;
    }

    public function setZoneDeStockage(?string $zoneDeStockage): self
    {
        $this->zoneDeStockage = $zoneDeStockage;

        return $this;
    }

    public function getManutentionSupplementaire(): ?string
    {
        return $this->manutentionSupplementaire;
    }

    public function setManutentionSupplementaire(?string $manutentionSupplementaire): self
    {
        $this->manutentionSupplementaire = $manutentionSupplementaire;

        return $this;
    }

    public function getMaterielAPrevoir(): ?string
    {
        return $this->materielAPrevoir;
    }

    public function setMaterielAPrevoir(?string $materielAPrevoir): self
    {
        $this->materielAPrevoir = $materielAPrevoir;

        return $this;
    }

    public function getStructureEchafaudage(): ?string
    {
        return $this->structureEchafaudage;
    }

    public function setStructureEchafaudage(?string $structureEchafaudage): self
    {
        $this->structureEchafaudage = $structureEchafaudage;

        return $this;
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): self
    {
        // unset the owning side of the relation if necessary
        if ($transport === null && $this->transport !== null) {
            $this->transport->setChantier(null);
        }

        // set the owning side of the relation if necessary
        if ($transport !== null && $transport->getChantier() !== $this) {
            $transport->setChantier($this);
        }

        $this->transport = $transport;

        return $this;
    }

    public function __toString():string
    {
        return $this->nomChantier;
    }
}
