<?php

namespace App\Entity;

use App\Entity\Affaire\Devis;
use App\Entity\Affaire\Evenement;
use App\Entity\Entite\Depot;
use App\Entity\Ged\Fichier;
use App\Entity\User\Poste;

use App\Entity\User\Service;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[Gedmo\Loggable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{


    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string')]
    private $password;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'boolean')]
    private $isActif;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'users')]
    private $service;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $matricule;

    #[ORM\ManyToOne(targetEntity: Poste::class, inversedBy: 'users')]
    private $poste;

    #[ORM\ManyToMany(targetEntity: Depot::class, mappedBy: 'users')]
    private $depots;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Fichier::class)]
    private $fichiers;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\Column(type: 'boolean')]
    private $locked;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $emailPerso;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Demande::class)]
    private $demandes;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Evenement::class)]
    private $evenements;

    #[ORM\OneToMany(mappedBy: 'referent', targetEntity: Devis::class)]
    private $devis;

    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'attribueA')]
    private $EvenementsAttribues;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Materiel::class)]
    private $materiels;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Pret::class)]
    private $prets;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephoneMobile;


    public function __construct()
    {
        $this->isActif = false;
        $this->locked = false;
        $this->depots = new ArrayCollection();
        $this->fichiers = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->evenements = new ArrayCollection();
        $this->evenementsAttribues = new ArrayCollection();
        $this->devis = new ArrayCollection();
        $this->EvenementsAttribues = new ArrayCollection();
        $this->materiels = new ArrayCollection();
        $this->prets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getmatricule(): ?string
    {
        return $this->matricule;
    }

    public function setmatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * @return Collection<int, Depot>
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->addUser($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            $depot->removeUser($this);
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
            $fichier->setCreateur($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getCreateur() === $this) {
                $fichier->setCreateur(null);
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

    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function getEmailPerso(): ?string
    {
        return $this->emailPerso;
    }

    public function setEmailPerso(?string $emailPerso): self
    {
        $this->emailPerso = $emailPerso;

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
            $demande->setCreateur($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getCreateur() === $this) {
                $demande->setCreateur(null);
            }
        }

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
            $evenement->setCreateur($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getCreateur() === $this) {
                $evenement->setCreateur(null);
            }
        }

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
            $devi->setReferent($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getReferent() === $this) {
                $devi->setReferent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenementsAttribues(): Collection
    {
        return $this->EvenementsAttribues;
    }

    public function addEvenementsAttribue(Evenement $evenementsAttribue): self
    {
        if (!$this->EvenementsAttribues->contains($evenementsAttribue)) {
            $this->EvenementsAttribues[] = $evenementsAttribue;
            $evenementsAttribue->addAttribueA($this);
        }

        return $this;
    }

    public function removeEvenementsAttribue(Evenement $evenementsAttribue): self
    {
        if ($this->EvenementsAttribues->removeElement($evenementsAttribue)) {
            $evenementsAttribue->removeAttribueA($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): self
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels[] = $materiel;
            $materiel->setCreateur($this);
        }
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

    public function removeMateriel(Materiel $materiel): self
    {
        if ($this->materiels->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getCreateur() === $this) {
                $materiel->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pret>
     */
    public function getPrets(): Collection
    {
        return $this->prets;
    }

    public function addPret(Pret $pret): self
    {
        if (!$this->prets->contains($pret)) {
            $this->prets[] = $pret;
            $pret->setUtilisateur($this);
        }

        return $this;
    }

    public function removePret(Pret $pret): self
    {
        if ($this->prets->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getUtilisateur() === $this) {
                $pret->setUtilisateur(null);
            }
        }
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
}
