<?php

namespace App\Entity\Interlocuteur;

use App\Entity\Affaire\Transport;
use App\Entity\Contact\Contact;
use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterlocuteurRepository::class)]
class Interlocuteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\OneToOne(inversedBy: 'interlocuteur', targetEntity: Personne::class, cascade: ['persist', 'remove'])]
    private $personne;

    #[ORM\OneToOne(inversedBy: 'interlocuteur', targetEntity: Societe::class, cascade: ['persist', 'remove'])]
    private $societe;

    #[ORM\Column(type: 'array', nullable: true)]
    private $phone = [];

    #[ORM\OneToMany(mappedBy: 'societe', targetEntity: Contact::class)]
    private $contacts;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Demande::class)]
    private $demandes;

    #[ORM\OneToMany(mappedBy: 'intermediaire', targetEntity: Demande::class)]
    private $demandesIntermediaire;

    #[ORM\OneToMany(mappedBy: 'maitreDOuvrage', targetEntity: Demande::class)]
    private $demandesMaitreDOuvrage;

    #[ORM\OneToMany(mappedBy: 'interlocuteur', targetEntity: Fichier::class)]
    private $fichiers;

    #[ORM\Column(type: 'array', nullable: true)]
    private $roles = [];

    #[ORM\Column(type: 'array', nullable: true)]
    private $menu = [];

    #[ORM\OneToMany(mappedBy: 'sousTraitantPrincipal', targetEntity: Transport::class)]
    private $transports;

    #[ORM\OneToMany(mappedBy: 'transporteur', targetEntity: Transport::class)]
    private $transportTransporteur;


    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->demandesIntermediaire = new ArrayCollection();
        $this->demandesMaitreDOuvrage = new ArrayCollection();
        $this->fichiers = new ArrayCollection();
        $this->transports = new ArrayCollection();
        $this->transportTransporteur = new ArrayCollection();

    }

    public function __toString(): string
    {
        return (!empty($this->getSociete())) ? $this->getSociete()->getRaisonSociale() : $this->getPersonne()->getNom()." ".$this->getPersonne()->getPrenom();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getSociete(): ?Societe
    {
        return $this->societe;
    }

    public function setSociete(?Societe $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getPhone(): ?array
    {
        return $this->phone;
    }

    public function setPhone(?array $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setSociete($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getSociete() === $this) {
                $contact->setSociete(null);
            }
        }

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
            $demande->setClient($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getClient() === $this) {
                $demande->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesIntermediaire(): Collection
    {
        return $this->demandesIntermediaire;
    }

    public function addDemandesIntermediaire(Demande $demandesIntermediaire): self
    {
        if (!$this->demandesIntermediaire->contains($demandesIntermediaire)) {
            $this->demandesIntermediaire[] = $demandesIntermediaire;
            $demandesIntermediaire->setIntermediaire($this);
        }

        return $this;
    }

    public function removeDemandesIntermediaire(Demande $demandesIntermediaire): self
    {
        if ($this->demandesIntermediaire->removeElement($demandesIntermediaire)) {
            // set the owning side to null (unless already changed)
            if ($demandesIntermediaire->getIntermediaire() === $this) {
                $demandesIntermediaire->setIntermediaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesMaitreDOuvrage(): Collection
    {
        return $this->demandesMaitreDOuvrage;
    }

    public function addDemandesMaitreDOuvrage(Demande $demandesMaitreDOuvrage): self
    {
        if (!$this->demandesMaitreDOuvrage->contains($demandesMaitreDOuvrage)) {
            $this->demandesMaitreDOuvrage[] = $demandesMaitreDOuvrage;
            $demandesMaitreDOuvrage->setMaitreDOuvrage($this);
        }

        return $this;
    }

    public function removeDemandesMaitreDOuvrage(Demande $demandesMaitreDOuvrage): self
    {
        if ($this->demandesMaitreDOuvrage->removeElement($demandesMaitreDOuvrage)) {
            // set the owning side to null (unless already changed)
            if ($demandesMaitreDOuvrage->getMaitreDOuvrage() === $this) {
                $demandesMaitreDOuvrage->setMaitreDOuvrage(null);
            }
        }

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
            $fichier->setInterlocuteur($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getInterlocuteur() === $this) {
                $fichier->setInterlocuteur(null);
            }
        }

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

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
            $transport->setSousTraitantPrincipal($this);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): self
    {
        if ($this->transports->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getSousTraitantPrincipal() === $this) {
                $transport->setSousTraitantPrincipal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transport>
     */
    public function getTransportTransporteur(): Collection
    {
        return $this->transportTransporteur;
    }

    public function addTransportTransporteur(Transport $transportTransporteur): self
    {
        if (!$this->transportTransporteur->contains($transportTransporteur)) {
            $this->transportTransporteur[] = $transportTransporteur;
            $transportTransporteur->setTransporteur($this);
        }

        return $this;
    }

    public function removeTransportTransporteur(Transport $transportTransporteur): self
    {
        if ($this->transportTransporteur->removeElement($transportTransporteur)) {
            // set the owning side to null (unless already changed)
            if ($transportTransporteur->getTransporteur() === $this) {
                $transportTransporteur->setTransporteur(null);
            }
        }

        return $this;
    }



}
