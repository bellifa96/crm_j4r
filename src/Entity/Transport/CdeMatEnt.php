<?php

namespace App\Entity\Transport;

use App\Repository\Transport\CdeMatEntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CdeMatEntRepository::class)]
class CdeMatEnt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NumDevis = 0;

    #[ORM\Column]
    private ?int $IdClient = 0;

    #[ORM\Column(length: 255)]
    private ?string $NomClient = '';

    #[ORM\Column(nullable: true)]
    private ?int $CodeChantier = 0;

    #[ORM\Column(length: 20)]
    private ?string $NumAffaire = '';

    #[ORM\Column(length: 500)]
    private ?string $AdresseChantier = '';

    #[ORM\Column(length: 10)]
    private ?string $CpChantier = '';

    #[ORM\Column(length: 50)]
    private ?string $VilleChantier = '';

    #[ORM\Column(length: 255)]
    private ?string $Commentaires = '';

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateCde = null;

    #[ORM\Column(length: 8)]
    private ?string $DateCdeInv = '';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $PoidsTotMat = '0.00';

    #[ORM\Column(length: 5)]
    private ?string $Initiales = '';

    #[ORM\Column]
    private ?int $IdAgence = 0;

    #[ORM\Column]
    private ?int $Iddepot = 0;

    #[ORM\Column]
    private ?bool $ValidationLayher = false;

    #[ORM\Column]
    private ?bool $ValidationJ4R = false;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $NumErpLocation = '0';

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $NumErpVente = '0';

    #[ORM\Column]
    private ?bool $CdeValide = false;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEnlevDem = null;

    #[ORM\Column(length: 8)]
    private ?string $DateEnlevDemInv = '';

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureEnlevDem = null;

    #[ORM\Column(length: 8)]
    private ?string $HeureEnlevDemTxt = '';

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEnlevReel = null;

    #[ORM\Column(length: 8)]
    private ?string $DateenlevReelInv = '';

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureEnlevReel = null;

    #[ORM\Column(length: 8)]
    private ?string $HeureEnlevReelTxt = '';

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateLiv = null;

    #[ORM\Column(length: 8)]
    private ?string $DateLivInv = '';

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureLiv = null;

    #[ORM\Column(length: 8)]
    private ?string $HeureLivTxt = '';

    #[ORM\Column]
    private ?int $NumEchange = 0;

    #[ORM\Column(nullable: true)]
    private ?int $NumAgenceLayher = null;

    #[ORM\Column(nullable: true)]
    private ?int $numCloud = null;

    #[ORM\Column(length: 8)]
    private ?string $Commentaires1 = '';

    #[ORM\Column(length: 8)]
    private ?string $Commentaires2 = '';

    #[ORM\Column]
    private ?int $Actif = 0;

    #[ORM\Column(length: 8)]
    private ?string $Motif = '';


    public function getActif(): ?int {
        return $this->Actif;
    }

    public function setActif(?int $Actif): void {
        $this->Actif = $Actif;
    }

    // Getter and Setter for Motif
    public function getMotif(): ?string {
        return $this->Motif;
    }

    public function setMotif(?string $Motif) {
        $this->Motif = $Motif;
    }

    public function __construct() {
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

    public function getNumDevis(): ?int
    {
        return $this->NumDevis;
    }

    public function setNumDevis(int $NumDevis): self
    {
        $this->NumDevis = $NumDevis;

        return $this;
    }

    public function getIdClient(): ?int
    {
        return $this->IdClient;
    }

    public function setIdClient(int $IdClient): self
    {
        $this->IdClient = $IdClient;

        return $this;
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

    public function getCodeChantier(): ?int
    {
        return $this->CodeChantier;
    }

    public function setCodeChantier(?int $CodeChantier): self
    {
        $this->CodeChantier = $CodeChantier;

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

    public function getAdresseChantier(): ?string
    {
        return $this->AdresseChantier;
    }

    public function setAdresseChantier(?string $AdresseChantier): self
    {
        $this->AdresseChantier = $AdresseChantier;

        return $this;
    }

    public function getCpChantier(): ?string
    {
        return $this->CpChantier;
    }

    public function setCpChantier(?string $CpChantier): self
    {
        $this->CpChantier = $CpChantier;

        return $this;
    }

    public function getVilleChantier(): ?string
    {
        return $this->VilleChantier;
    }

    public function setVilleChantier(?string $VilleChantier): self
    {
        $this->VilleChantier = $VilleChantier;

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

    public function getDateCde(): ?\DateTimeInterface
    {
        return $this->DateCde;
    }

    public function setDateCde(\DateTimeInterface $DateCde): self
    {
        $this->DateCde = $DateCde;

        return $this;
    }

    public function getDateCdeInv(): ?string
    {
        return $this->DateCdeInv;
    }

    public function setDateCdeInv(string $DateCdeInv): self
    {
        $this->DateCdeInv = $DateCdeInv;

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

    public function getInitiales(): ?string
    {
        return $this->Initiales;
    }

    public function setInitiales(?string $Initiales): self
    {
        $this->Initiales = $Initiales;

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

    public function isValidationLayher(): ?bool
    {
        return $this->ValidationLayher;
    }

    public function setValidationLayher(bool $ValidationLayher): self
    {
        $this->ValidationLayher = $ValidationLayher;

        return $this;
    }

    public function isValidationJ4R(): ?bool
    {
        return $this->ValidationJ4R;
    }

    public function setValidationJ4R(bool $ValidationJ4R): self
    {
        $this->ValidationJ4R = $ValidationJ4R;

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

    public function isCdeValide(): ?bool
    {
        return $this->CdeValide;
    }

    public function setCdeValide(bool $CdeValide): self
    {
        $this->CdeValide = $CdeValide;

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

    public function getDateEnlevDemInv(): ?string
    {
        return $this->DateEnlevDemInv;
    }

    public function setDateEnlevDemInv(?string $DateEnlevDemInv): self
    {
        $this->DateEnlevDemInv = $DateEnlevDemInv;

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

    public function getHeureEnlevDemTxt(): ?string
    {
        return $this->HeureEnlevDemTxt;
    }

    public function setHeureEnlevDemTxt(?string $HeureEnlevDemTxt): self
    {
        $this->HeureEnlevDemTxt = $HeureEnlevDemTxt;

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

    public function getDateenlevReelInv(): ?string
    {
        return $this->DateenlevReelInv;
    }

    public function setDateenlevReelInv(?string $DateenlevReelInv): self
    {
        $this->DateenlevReelInv = $DateenlevReelInv;

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

    public function getHeureEnlevReelTxt(): ?string
    {
        return $this->HeureEnlevReelTxt;
    }

    public function setHeureEnlevReelTxt(?string $HeureEnlevReelTxt): self
    {
        $this->HeureEnlevReelTxt = $HeureEnlevReelTxt;

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

    public function getDateLivInv(): ?string
    {
        return $this->DateLivInv;
    }

    public function setDateLivInv(?string $DateLivInv): self
    {
        $this->DateLivInv = $DateLivInv;

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

    public function getHeureLivTxt(): ?string
    {
        return $this->HeureLivTxt;
    }

    public function setHeureLivTxt(?string $HeureLivTxt): self
    {
        $this->HeureLivTxt = $HeureLivTxt;

        return $this;
    }

    public function getNumEchange(): ?int
    {
        return $this->NumEchange;
    }
    public function  setNumCloud(int $Numcloud)
    {
        $this->numCloud = $Numcloud;
    }
    public function getNumCloud(): ?int
    {
        return $this->numCloud;
    }

    public function setNumEchange(int $NumEchange): self
    {
        $this->NumEchange = $NumEchange;

        return $this;
    }

    public function getNumAgenceLayher(): ?int
    {
        return $this->NumAgenceLayher;
    }

    public function setNumAgenceLayher(?int $NumAgenceLayher): self
    {
        $this->NumAgenceLayher = $NumAgenceLayher;

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
