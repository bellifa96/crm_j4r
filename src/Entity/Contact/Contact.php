<?php

namespace App\Entity\Contact;

use App\Entity\AdresseTrait;
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

    #[ORM\ManyToMany(targetEntity: Demande::class, mappedBy: 'ContactsSecondairesClient')]
    private $contactSecondairesDemandes;

    #[ORM\OneToMany(mappedBy: 'contactMaitreDOuvrage', targetEntity: Demande::class)]
    private $DemandesContactMaitreDOuvrage;

    #[ORM\ManyToMany(targetEntity: Demande::class, mappedBy: 'contactMaitreDOuvrageSecondaires')]
    private $demandesContactMaitreDOuvrageSecondaires;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->contactSecondairesDemandes = new ArrayCollection();
        $this->DemandesContactMaitreDOuvrage = new ArrayCollection();
        $this->demandesContactMaitreDOuvrageSecondaires = new ArrayCollection();
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
    public function getContactSecondairesDemandes(): Collection
    {
        return $this->contactSecondairesDemandes;
    }

    public function addContactSecondairesDemande(Demande $contactSecondairesDemande): self
    {
        if (!$this->contactSecondairesDemandes->contains($contactSecondairesDemande)) {
            $this->contactSecondairesDemandes[] = $contactSecondairesDemande;
            $contactSecondairesDemande->addContactsSecondairesClient($this);
        }

        return $this;
    }

    public function removeContactSecondairesDemande(Demande $contactSecondairesDemande): self
    {
        if ($this->contactSecondairesDemandes->removeElement($contactSecondairesDemande)) {
            $contactSecondairesDemande->removeContactsSecondairesClient($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesContactMaitreDOuvrage(): Collection
    {
        return $this->DemandesContactMaitreDOuvrage;
    }

    public function addDemandesContactMaitreDOuvrage(Demande $demandesContactMaitreDOuvrage): self
    {
        if (!$this->DemandesContactMaitreDOuvrage->contains($demandesContactMaitreDOuvrage)) {
            $this->DemandesContactMaitreDOuvrage[] = $demandesContactMaitreDOuvrage;
            $demandesContactMaitreDOuvrage->setContactMaitreDOuvrage($this);
        }

        return $this;
    }

    public function removeDemandesContactMaitreDOuvrage(Demande $demandesContactMaitreDOuvrage): self
    {
        if ($this->DemandesContactMaitreDOuvrage->removeElement($demandesContactMaitreDOuvrage)) {
            // set the owning side to null (unless already changed)
            if ($demandesContactMaitreDOuvrage->getContactMaitreDOuvrage() === $this) {
                $demandesContactMaitreDOuvrage->setContactMaitreDOuvrage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandesContactMaitreDOuvrageSecondaires(): Collection
    {
        return $this->demandesContactMaitreDOuvrageSecondaires;
    }

    public function addDemandesContactMaitreDOuvrageSecondaire(Demande $demandesContactMaitreDOuvrageSecondaire): self
    {
        if (!$this->demandesContactMaitreDOuvrageSecondaires->contains($demandesContactMaitreDOuvrageSecondaire)) {
            $this->demandesContactMaitreDOuvrageSecondaires[] = $demandesContactMaitreDOuvrageSecondaire;
            $demandesContactMaitreDOuvrageSecondaire->addContactMaitreDOuvrageSecondaire($this);
        }

        return $this;
    }

    public function removeDemandesContactMaitreDOuvrageSecondaire(Demande $demandesContactMaitreDOuvrageSecondaire): self
    {
        if ($this->demandesContactMaitreDOuvrageSecondaires->removeElement($demandesContactMaitreDOuvrageSecondaire)) {
            $demandesContactMaitreDOuvrageSecondaire->removeContactMaitreDOuvrageSecondaire($this);
        }

        return $this;
    }
}
