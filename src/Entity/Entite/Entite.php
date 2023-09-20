<?php

namespace App\Entity\Entite;

use App\Entity\AdresseTrait;
use App\Entity\TimesTrait;
use App\Entity\User;
use App\Repository\Entite\EntiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntiteRepository::class)]
class Entite
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
    private $activitePrincipale;

    #[ORM\Column(type: 'string', length: 255)]
    private $siret;

    #[ORM\Column(type: 'string', length: 255)]
    private $formeJuridique;

    #[ORM\Column(type: 'string', length: 255)]
    private $Dirigeant;

    #[ORM\Column(type: 'string', length: 255)]
    private $dateDeCreation;

    #[ORM\OneToMany(mappedBy: 'entite', targetEntity: SousEntite::class)]
    private $sousEntites;

    #[ORM\OneToMany(mappedBy: 'entite', targetEntity: User::class)]
    private $users;

    public function __construct()
    {
        $this->sousEntites = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getActivitePrincipale(): ?string
    {
        return $this->activitePrincipale;
    }

    public function setActivitePrincipale(string $activitePrincipale): self
    {
        $this->activitePrincipale = $activitePrincipale;

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

    public function setFormeJuridique(string $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getDirigeant(): ?string
    {
        return $this->Dirigeant;
    }

    public function setDirigeant(string $Dirigeant): self
    {
        $this->Dirigeant = $Dirigeant;

        return $this;
    }

    public function getDateDeCreation(): ?string
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation(string $dateDeCreation): self
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    /**
     * @return Collection<int, SousEntite>
     */
    public function getSousEntites(): Collection
    {
        return $this->sousEntites;
    }

    public function addSousEntite(SousEntite $sousEntite): self
    {
        if (!$this->sousEntites->contains($sousEntite)) {
            $this->sousEntites[] = $sousEntite;
            $sousEntite->setEntite($this);
        }

        return $this;
    }

    public function removeSousEntite(SousEntite $sousEntite): self
    {
        if ($this->sousEntites->removeElement($sousEntite)) {
            // set the owning side to null (unless already changed)
            if ($sousEntite->getEntite() === $this) {
                $sousEntite->setEntite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setEntite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getEntite() === $this) {
                $user->setEntite(null);
            }
        }

        return $this;
    }
}
