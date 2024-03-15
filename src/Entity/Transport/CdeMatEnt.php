<?php

namespace App\Entity\Transport;

use App\Entity\Depot\Chantiers;
use App\Entity\Depot\Transports;
use App\Entity\User;
use App\Repository\Transport\CdeMatEntRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CdeMatEntRepository::class)]
class CdeMatEnt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;





    #[ORM\Column(length: 255)]
    private ?string $NomClient = '';



    #[ORM\Column(length: 20)]
    private ?string $NumAffaire = '';



    #[ORM\Column(length: 255)]
    private ?string $Commentaires = '';

    #[ORM\Column(type: "datetime")]
    private  $DateCde = null;



    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $PoidsTotMat = '0.00';



    #[ORM\Column]
    private ?int $IdAgence = 0;

    #[ORM\Column]
    private ?int $Iddepot = 0;



    #[ORM\Column(type: Types::BIGINT)]
    private ?string $NumErpLocation = '0';

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $NumErpVente = '0';



    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEnlevDem = null;



    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureEnlevDem = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEnlevReel = null;



    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureEnlevReel = null;



    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateLiv = null;



    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureLiv = null;


    #[ORM\Column]
    private ?int $NumEchange = 0;



    #[ORM\Column(length: 8)]
    private ?string $Commentaires1 = '';

    #[ORM\Column(length: 8)]
    private ?string $Commentaires2 = '';

    #[ORM\Column(type: "boolean")]
    private  $Actif;

    #[ORM\Column(type: "string", length: 1500)]
    private  $Motif;

    #[ORM\Column(type: "string")]
    private $Idcalendar;

    #[ORM\Column(type: "string")]
    private $adresse_chantier;

    #[ORM\OneToMany(targetEntity: Transports::class, mappedBy: 'idcde')]
    #[Groups(['cde_mat_ent'])]
    private $transports;


    #[ORM\ManyToOne(targetEntity: Chantiers::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'id_chantier', referencedColumnName: 'idchantier')]
    private $id_chantier;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'id_conducteur', referencedColumnName: 'id')]
    private $id_conducteur;

    /**
     * Get the value of conducteur
     *
     * @return User|null
     */
    public function getConducteur(): ?User
    {
        return $this->id_conducteur;
    }

    /**
     * Set the value of conducteur
     *
     * @param User|null $conducteur
     * @return self
     */
    public function setConducteur(?User $conducteur): self
    {
        $this->id_conducteur = $conducteur;

        return $this;
    }



    public function getChantier(): ?Chantiers // Assurez-vous que le type est correct
    {
        return $this->id_chantier;
    }

    // Setter pour $chantier
    public function setChantier(?Chantiers $chantier): self // Utilisez le bon type d'objet
    {
        $this->id_chantier = $chantier;

        return $this;
    }

    // Getter pour $conducteur


    // Setter pour $conducteur



    public function getIdCalendar()
    {
        return $this->Idcalendar;
    }

    public function setIdCalendar($Idcalendar)
    {
        $this->Idcalendar = $Idcalendar;
    }

    /**
     * @return Collection|Transports[]
     */
    public function getTransports(): Collection
    {
        return $this->transports;
    }



    public function getActif()
    {
        return $this->Actif;
    }

    public function setActif($Actif): void
    {
        $this->Actif = $Actif;
    }

    // Getter and Setter for Motif
    public function getMotif()
    {
        return $this->Motif;
    }

    public function setMotif($Motif)
    {
        $this->Motif = $Motif;
    }

    public function __construct()
    {
        $this->transports = new ArrayCollection();

        if ($this->DateCde === null) {
            $this->DateCde = new \DateTime();
        }

        if ($this->HeureEnlevDem === null) {
            $this->HeureEnlevDem = new \DateTime();
        }

        if ($this->DateEnlevDem === null) {
            $this->DateEnlevDem = new \DateTime();
        }

        if ($this->DateEnlevReel === null) {
            $this->DateEnlevReel = new \DateTime();
        }

        if ($this->HeureEnlevReel === null) {
            $this->HeureEnlevReel = new \DateTime();
        }

        if ($this->DateLiv === null) {
            $this->DateLiv = new \DateTime();
        }

        if ($this->HeureLiv === null) {
            $this->HeureLiv = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNomClient(): ?string
    {
        return $this->NomClient;
    }

    public function setNomClient(string $NomClient): self
    {
        $this->NomClient = $NomClient;

        return $this;
    }

    public function getAdresseChantier(): ?string
    {
        return $this->adresse_chantier;
    }

    public function setAdresseChantier(string $adresse): self
    {
        $this->adresse_chantier = $adresse;

        return $this;
    }




    public function getNumAffaire(): ?string
    {
        return $this->NumAffaire;
    }

    public function setNumAffaire(?string $NumAffaire): self
    {
        $this->NumAffaire = $NumAffaire;

        return $this;
    }







    public function getCommentaires(): ?string
    {
        return $this->Commentaires;
    }

    public function setCommentaires(?string $Commentaires): self
    {
        $this->Commentaires = $Commentaires;

        return $this;
    }

    public function getDateCde()
    {
        return $this->DateCde;
    }

    public function setDateCde($DateCde): self
    {
        $this->DateCde = $DateCde;

        return $this;
    }



    public function getPoidsTotMat(): ?string
    {
        return $this->PoidsTotMat;
    }

    public function setPoidsTotMat(string $PoidsTotMat): self
    {
        $this->PoidsTotMat = $PoidsTotMat;

        return $this;
    }


    public function getIdAgence(): ?int
    {
        return $this->IdAgence;
    }

    public function setIdAgence(int $IdAgence): self
    {
        $this->IdAgence = $IdAgence;

        return $this;
    }

    public function getIddepot(): ?int
    {
        return $this->Iddepot;
    }

    public function setIddepot(int $Iddepot): self
    {
        $this->Iddepot = $Iddepot;

        return $this;
    }



    public function getNumErpLocation(): ?string
    {
        return $this->NumErpLocation;
    }

    public function setNumErpLocation(?string $NumErpLocation): self
    {
        $this->NumErpLocation = $NumErpLocation;

        return $this;
    }

    public function getNumErpVente(): ?string
    {
        return $this->NumErpVente;
    }

    public function setNumErpVente(?string $NumErpVente): self
    {
        $this->NumErpVente = $NumErpVente;

        return $this;
    }

   

    public function getDateEnlevDem(): ?\DateTimeInterface
    {
        return $this->DateEnlevDem;
    }

    public function setDateEnlevDem(?\DateTimeInterface $DateEnlevDem): self
    {
        $this->DateEnlevDem = $DateEnlevDem;

        return $this;
    }



    public function getHeureEnlevDem(): ?\DateTimeInterface
    {
        return $this->HeureEnlevDem;
    }

    public function setHeureEnlevDem(?\DateTimeInterface $HeureEnlevDem): self
    {
        $this->HeureEnlevDem = $HeureEnlevDem;

        return $this;
    }



    public function getDateEnlevReel(): ?\DateTimeInterface
    {
        return $this->DateEnlevReel;
    }

    public function setDateEnlevReel(?\DateTimeInterface $DateEnlevReel): self
    {
        $this->DateEnlevReel = $DateEnlevReel;

        return $this;
    }


    public function getHeureEnlevReel(): ?\DateTimeInterface
    {
        return $this->HeureEnlevReel;
    }

    public function setHeureEnlevReel(?\DateTimeInterface $HeureEnlevReel): self
    {
        $this->HeureEnlevReel = $HeureEnlevReel;

        return $this;
    }



    public function getDateLiv(): ?\DateTimeInterface
    {
        return $this->DateLiv;
    }

    public function setDateLiv(?\DateTimeInterface $DateLiv): self
    {
        $this->DateLiv = $DateLiv;

        return $this;
    }



    public function getHeureLiv(): ?\DateTimeInterface
    {
        return $this->HeureLiv;
    }

    public function setHeureLiv(?\DateTimeInterface $HeureLiv): self
    {
        $this->HeureLiv = $HeureLiv;

        return $this;
    }


    public function getNumEchange(): ?int
    {
        return $this->NumEchange;
    }


    public function setNumEchange(int $NumEchange): self
    {
        $this->NumEchange = $NumEchange;

        return $this;
    }



    /**
     * Get the value of Commentaires1
     *
     * @return string|null
     */
    public function getCommentaires1(): ?string
    {
        return $this->Commentaires1;
    }

    /**
     * Set the value of Commentaires1
     *
     * @param string|null $Commentaires1
     * @return self
     */
    public function setCommentaires1(?string $Commentaires1): self
    {
        $this->Commentaires1 = $Commentaires1;

        return $this;
    }

    /**
     * Get the value of Commentaires2
     *
     * @return string|null
     */
    public function getCommentaires2(): ?string
    {
        return $this->Commentaires2;
    }

    /**
     * Set the value of Commentaires2
     *
     * @param string|null $Commentaires2
     * @return self
     */
    public function setCommentaires2(?string $Commentaires2): self
    {
        $this->Commentaires2 = $Commentaires2;

        return $this;
    }
}
