<?php

namespace App\Entity\Affaire;

use App\Entity\Contact\Contact;
use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\TimesTrait;
use App\Entity\User;
use App\Repository\Affaire\TransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'transports')]
    private $donneurDOrdre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $codeChantierJ4R;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'transportConducteurTravaux')]
    private $ConducteurDeTravaux;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'transports')]
    private $sousTraitantPrincipal;

    #[ORM\Column(type: 'string', length: 255)]
    private $codeChantierLayher;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $referenceCommande;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $codeERP;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nCommande;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDeTransport;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDeVehicule;

    #[ORM\Column(type: 'string', length: 255)]
    private $tonnageCommande;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tonnagePrepare;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tonnageLivre;

    #[ORM\Column(type: 'string', length: 255)]
    private $montantDeLaCourse;

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'transports')]
    private $chauffeur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adresseEnlevement;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'transportTransporteur')]
    private $transporteur;

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'TransportContactEnlevement')]
    private $contactEnlevement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateDEnlevementDemande;

    #[ORM\Column(type: 'text', nullable: true)]
    private $instructionEnlevementConducteur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adresseLivraison;

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'transportLivraison')]
    private $contactLivraison;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateLivraisonDemande;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $referenceLivraison;

    #[ORM\Column(type: 'text', nullable: true)]
    private $instructionLivraisonConducteur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $referenceEnlevement;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $heureEnlevement;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $heureLivraison;

    #[ORM\Column(type: 'array')]
    private $prix = [];

    #[ORM\OneToOne(inversedBy: 'transport', targetEntity: Demande::class, cascade: ['persist', 'remove'])]
    private $chantier;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $statut;

    #[ORM\Column(type: 'text', nullable: true)]
    private $instructionCommande;

    #[ORM\OneToMany(mappedBy: 'transport', targetEntity: Fichier::class, cascade: ["persist"])]
    private $fichiers;


    public function __construct()
    {
        $this->prix['type'] = "A la tonne";
        $this->prix['montant'] = 42;
        $this->codeChantierLayher = "100FUR";
        $this->statut = "Demande CDT";
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonneurDOrdre(): ?User
    {
        return $this->donneurDOrdre;
    }

    public function setDonneurDOrdre(?User $donneurDOrdre): self
    {
        $this->donneurDOrdre = $donneurDOrdre;

        return $this;
    }

    public function getCodeChantierJ4R(): ?string
    {
        return $this->codeChantierJ4R;
    }

    public function setCodeChantierJ4R(?string $codeChantierJ4R): self
    {
        $this->codeChantierJ4R = $codeChantierJ4R;

        return $this;
    }

    public function getConducteurDeTravaux(): ?User
    {
        return $this->ConducteurDeTravaux;
    }

    public function setConducteurDeTravaux(?User $ConducteurDeTravaux): self
    {
        $this->ConducteurDeTravaux = $ConducteurDeTravaux;

        return $this;
    }

    public function getSousTraitantPrincipal(): ?Interlocuteur
    {
        return $this->sousTraitantPrincipal;
    }

    public function setSousTraitantPrincipal(?Interlocuteur $sousTraitantPrincipal): self
    {
        $this->sousTraitantPrincipal = $sousTraitantPrincipal;

        return $this;
    }

    public function getCodeChantierLayher(): ?string
    {
        return $this->codeChantierLayher;
    }

    public function setCodeChantierLayher(string $codeChantierLayher): self
    {
        $this->codeChantierLayher = $codeChantierLayher;

        return $this;
    }

    public function getReferenceCommande(): ?string
    {
        return $this->referenceCommande;
    }

    public function setReferenceCommande(?string $referenceCommande): self
    {
        $this->referenceCommande = $referenceCommande;

        return $this;
    }


    public function getCodeERP(): ?string
    {
        return $this->codeERP;
    }

    public function setCodeERP(?string $codeERP): self
    {
        $this->codeERP = $codeERP;

        return $this;
    }

    public function getNCommande(): ?string
    {
        return $this->nCommande;
    }

    public function setNCommande(?string $nCommande): self
    {
        $this->nCommande = $nCommande;

        return $this;
    }

    public function getTypeDeTransport(): ?string
    {
        return $this->typeDeTransport;
    }

    public function setTypeDeTransport(string $typeDeTransport): self
    {
        $this->typeDeTransport = $typeDeTransport;

        return $this;
    }

    public function getTypeDeVehicule(): ?string
    {
        return $this->typeDeVehicule;
    }

    public function setTypeDeVehicule(string $typeDeVehicule): self
    {
        $this->typeDeVehicule = $typeDeVehicule;

        return $this;
    }

    public function getTonnageCommande(): ?string
    {
        return $this->tonnageCommande;
    }

    public function setTonnageCommande(string $tonnageCommande): self
    {
        $this->tonnageCommande = $tonnageCommande;

        return $this;
    }

    public function getTonnagePrepare(): ?string
    {
        return $this->tonnagePrepare;
    }

    public function setTonnagePrepare(?string $tonnagePrepare): self
    {
        $this->tonnagePrepare = $tonnagePrepare;

        return $this;
    }

    public function getTonnageLivre(): ?string
    {
        return $this->tonnageLivre;
    }

    public function setTonnageLivre(string $tonnageLivre): self
    {
        $this->tonnageLivre = $tonnageLivre;

        return $this;
    }

    public function getMontantDeLaCourse(): ?string
    {
        return $this->montantDeLaCourse;
    }

    public function setMontantDeLaCourse(string $montantDeLaCourse): self
    {
        $this->montantDeLaCourse = $montantDeLaCourse;

        return $this;
    }

    public function getChauffeur(): ?Contact
    {
        return $this->chauffeur;
    }

    public function setChauffeur(?Contact $chauffeur): self
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }


    public function getAdresseEnlevement(): ?string
    {
        return $this->adresseEnlevement;
    }

    public function setAdresseEnlevement(?string $adresseEnlevement): self
    {
        $this->adresseEnlevement = $adresseEnlevement;

        return $this;
    }

    public function getTransporteur(): ?Interlocuteur
    {
        return $this->transporteur;
    }

    public function setTransporteur(?Interlocuteur $transporteur): self
    {
        $this->transporteur = $transporteur;

        return $this;
    }

    public function getContactEnlevement(): ?Contact
    {
        return $this->contactEnlevement;
    }

    public function setContactEnlevement(?Contact $contactEnlevement): self
    {
        $this->contactEnlevement = $contactEnlevement;

        return $this;
    }

    public function getDateDEnlevementDemande(): ?string
    {
        return $this->dateDEnlevementDemande;
    }

    public function setDateDEnlevementDemande(?string $dateDEnlevementDemande): self
    {
        $this->dateDEnlevementDemande = $dateDEnlevementDemande;

        return $this;
    }

    public function getInstructionEnlevementConducteur(): ?string
    {
        return $this->instructionEnlevementConducteur;
    }

    public function setInstructionEnlevementConducteur(?string $instructionEnlevementConducteur): self
    {
        $this->instructionEnlevementConducteur = $instructionEnlevementConducteur;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(?string $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getContactLivraison(): ?Contact
    {
        return $this->contactLivraison;
    }

    public function setContactLivraison(?Contact $contactLivraison): self
    {
        $this->contactLivraison = $contactLivraison;

        return $this;
    }

    public function getDateLivraisonDemande(): ?string
    {
        return $this->dateLivraisonDemande;
    }

    public function setDateLivraisonDemande(?string $dateLivraisonDemande): self
    {
        $this->dateLivraisonDemande = $dateLivraisonDemande;

        return $this;
    }

    public function getReferenceLivraison(): ?string
    {
        return $this->referenceLivraison;
    }

    public function setReferenceLivraison(?string $referenceLivraison): self
    {
        $this->referenceLivraison = $referenceLivraison;

        return $this;
    }

    public function getInstructionLivraisonConducteur(): ?string
    {
        return $this->instructionLivraisonConducteur;
    }

    public function setInstructionLivraisonConducteur(?string $instructionLivraisonConducteur): self
    {
        $this->instructionLivraisonConducteur = $instructionLivraisonConducteur;

        return $this;
    }


    public function getReferenceEnlevement(): ?string
    {
        return $this->referenceEnlevement;
    }

    public function setReferenceEnlevement(string $referenceEnlevement): self
    {
        $this->referenceEnlevement = $referenceEnlevement;

        return $this;
    }

    public function getheureEnlevement(): ?\datetime
    {
        return $this->heureEnlevement;
    }

    public function setheureEnlevement(?\datetime $heureEnlevement): self
    {
        $this->heureEnlevement = $heureEnlevement;

        return $this;
    }

    public function getheureLivraison(): ?\datetime
    {
        return $this->heureLivraison;
    }

    public function setheureLivraison(?\datetime $heureLivraison): self
    {
        $this->heureLivraison = $heureLivraison;

        return $this;
    }


    public function getPrix(): ?array
    {
        return $this->prix;
    }

    public function setPrix(array $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getChantier(): ?Demande
    {
        return $this->chantier;
    }

    public function setChantier(?Demande $chantier): self
    {
        $this->chantier = $chantier;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getInstructionCommande(): ?string
    {
        return $this->instructionCommande;
    }

    public function setInstructionCommande(?string $instructionCommande): self
    {
        $this->instructionCommande = $instructionCommande;

        return $this;
    }

    /**
     * @return Collection<int, Fichier>
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers[] = $fichier;
            $fichier->setTransport($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getTransport() === $this) {
                $fichier->setTransport(null);
            }
        }

        return $this;
    }


}
