<?php

namespace App\Entity\Contact;

use App\Entity\AdresseTrait;
use App\Entity\Affaire\Transport;
use App\Entity\Demande;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Repository\Contact\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    use AdresseTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $telephoneMobile;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateAnniversaire;

    #[ORM\ManyToOne(targetEntity: Interlocuteur::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    private $societe;

    #[ORM\ManyToOne(targetEntity: ContactService::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    private $service;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $fonction;

    #[ORM\Column(type: 'string', length: 255)]
    private $genre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\OneToMany(mappedBy: 'contactPrincipalClient', targetEntity: Demande::class)]
    private $demandes;

    #[ORM\OneToMany(mappedBy: 'contactPrincipalMaitreDOuvrage', targetEntity: Demande::class)]
    private $demandesContactPrincipalMaitreDOuvrage;

    #[ORM\OneToMany(mappedBy: 'contactPrincipalIntermediaire', targetEntity: Demande::class)]
    private $demandesContactPrincipalIntermediaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lienLinkedin;

    #[ORM\ManyToOne(targetEntity: Demande::class, inversedBy: 'contactsSecondaires')]
    private $contactsSecondaires;

    #[ORM\OneToMany(mappedBy: 'chauffeur', targetEntity: Transport::class)]
    private $transports;

    #[ORM\OneToMany(mappedBy: 'contactEnlevement', targetEntity: Transport::class)]
    private $TransportContactEnlevement;

    #[ORM\OneToMany(mappedBy: 'contactLivraison', targetEntity: Transport::class)]
    private $transportLivraison;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->DemandesContactMaitreDOuvrage = new ArrayCollection();
        $this->demandesContactPrincipalMaitreDOuvrage = new ArrayCollection();
        $this->demandesContactPrincipalIntermediaire = new ArrayCollection();
        $this->transports = new ArrayCollection();
        $this->TransportContactEnlevement = new ArrayCollection();
        $this->transportLivraison = new ArrayCollection();
    }

    public function __toString() :string
    {
        return  $this->nom." ".$this->prenom;
    }
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getTelephoneMobile(): ?string
    {
        return $this->telephoneMobile;
    }

    public function setTelephoneMobile(string $telephoneMobile): self
    {
        $this->telephoneMobile = $telephoneMobile;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDateAnniversaire(): ?string
    {
        return $this->dateAnniversaire;
    }

    public function setDateAnniversaire(?string $dateAnniversaire): self
    {
        $this->dateAnniversaire = $dateAnniversaire;

        return $this;
    }

    public function getSociete(): ?Interlocuteur
    {
        return $this->societe;
    }

    public function setSociete(?Interlocuteur $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getService(): ?ContactService
    {
        return $this->service;
    }

    public function setService(?ContactService $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

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

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setContactPrincipalClient($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getContactPrincipalClient() === $this) {
                $demande->setContactPrincipalClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesContactPrincipalMaitreDOuvrage(): Collection
    {
        return $this->demandesContactPrincipalMaitreDOuvrage;
    }

    public function addDemandesContactPrincipalMaitreDOuvrage(Demande $demandesContactPrincipalMaitreDOuvrage): self
    {
        if (!$this->demandesContactPrincipalMaitreDOuvrage->contains($demandesContactPrincipalMaitreDOuvrage)) {
            $this->demandesContactPrincipalMaitreDOuvrage[] = $demandesContactPrincipalMaitreDOuvrage;
            $demandesContactPrincipalMaitreDOuvrage->setContactPrincipalMaitreDOuvrage($this);
        }

        return $this;
    }

    public function removeDemandesContactPrincipalMaitreDOuvrage(Demande $demandesContactPrincipalMaitreDOuvrage): self
    {
        if ($this->demandesContactPrincipalMaitreDOuvrage->removeElement($demandesContactPrincipalMaitreDOuvrage)) {
            // set the owning side to null (unless already changed)
            if ($demandesContactPrincipalMaitreDOuvrage->getContactPrincipalMaitreDOuvrage() === $this) {
                $demandesContactPrincipalMaitreDOuvrage->setContactPrincipalMaitreDOuvrage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesContactPrincipalIntermediaire(): Collection
    {
        return $this->demandesContactPrincipalIntermediaire;
    }

    public function addDemandesContactPrincipalIntermediaire(Demande $demandesContactPrincipalIntermediaire): self
    {
        if (!$this->demandesContactPrincipalIntermediaire->contains($demandesContactPrincipalIntermediaire)) {
            $this->demandesContactPrincipalIntermediaire[] = $demandesContactPrincipalIntermediaire;
            $demandesContactPrincipalIntermediaire->setContactPrincipalIntermediaire($this);
        }

        return $this;
    }

    public function removeDemandesContactPrincipalIntermediaire(Demande $demandesContactPrincipalIntermediaire): self
    {
        if ($this->demandesContactPrincipalIntermediaire->removeElement($demandesContactPrincipalIntermediaire)) {
            // set the owning side to null (unless already changed)
            if ($demandesContactPrincipalIntermediaire->setContactPrincipalIntermediaire() === $this) {
                $demandesContactPrincipalIntermediaire->setContactPrincipalIntermediaire(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getLienLinkedin(): ?string
    {
        return $this->lienLinkedin;
    }

    public function setLienLinkedin(?string $lienLinkedin): self
    {
        $this->lienLinkedin = $lienLinkedin;

        return $this;
    }

    public function getContactsSecondaires(): ?Demande
    {
        return $this->contactsSecondaires;
    }

    public function setContactsSecondaires(?Demande $contactsSecondaires): self
    {
        $this->contactsSecondaires = $contactsSecondaires;

        return $this;
    }

    /**
     * @return Collection<int, Transport>
     */
    public function getTransports(): Collection
    {
        return $this->transports;
    }

    public function addTransport(Transport $transport): self
    {
        if (!$this->transports->contains($transport)) {
            $this->transports[] = $transport;
            $transport->setChauffeur($this);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): self
    {
        if ($this->transports->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getChauffeur() === $this) {
                $transport->setChauffeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transport>
     */
    public function getTransportContactEnlevement(): Collection
    {
        return $this->TransportContactEnlevement;
    }

    public function addTransportContactEnlevement(Transport $transportContactEnlevement): self
    {
        if (!$this->TransportContactEnlevement->contains($transportContactEnlevement)) {
            $this->TransportContactEnlevement[] = $transportContactEnlevement;
            $transportContactEnlevement->setContactEnlevement($this);
        }

        return $this;
    }

    public function removeTransportContactEnlevement(Transport $transportContactEnlevement): self
    {
        if ($this->TransportContactEnlevement->removeElement($transportContactEnlevement)) {
            // set the owning side to null (unless already changed)
            if ($transportContactEnlevement->getContactEnlevement() === $this) {
                $transportContactEnlevement->setContactEnlevement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transport>
     */
    public function getTransportLivraison(): Collection
    {
        return $this->transportLivraison;
    }

    public function addTransportLivraison(Transport $transportLivraison): self
    {
        if (!$this->transportLivraison->contains($transportLivraison)) {
            $this->transportLivraison[] = $transportLivraison;
            $transportLivraison->setContactLivraison($this);
        }

        return $this;
    }

    public function removeTransportLivraison(Transport $transportLivraison): self
    {
        if ($this->transportLivraison->removeElement($transportLivraison)) {
            // set the owning side to null (unless already changed)
            if ($transportLivraison->getContactLivraison() === $this) {
                $transportLivraison->setContactLivraison(null);
            }
        }

        return $this;
    }
}
