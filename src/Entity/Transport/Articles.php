<?php

namespace App\Entity\Transport;

use App\Repository\Transport\ArticlesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Depot = null;

    #[ORM\Column(length: 15)]
    private ?string $Article = null;

    #[ORM\Column(length: 255)]
    private ?string $Designation = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $PrixVente = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $PrixLoc = null;

    #[ORM\Column]
    private ?float $Poids = null;

    #[ORM\Column]
    private ?bool $Vente = null;

    #[ORM\Column]
    private ?bool $Location = null;

    #[ORM\Column]
    private ?bool $Consommable = null;

    #[ORM\Column]
    private ?bool $Conditionnement = null;

    #[ORM\Column]
    private ?int $QteTotale = null;

    #[ORM\Column]
    private ?int $QteDispo = null;

    #[ORM\Column]
    private ?int $QteSortie = null;

    #[ORM\Column]
    private ?int $QteReserve = null;

    #[ORM\Column]
    private ?int $QteTransit = null;

    #[ORM\Column]
    private ?int $QteTemp = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateAchat = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $DateAchatInv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Commentaires = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateSaisie = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $DateSaisieInv = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Emplacement = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $Image = null;

    #[ORM\Column]
    private ?bool $AControler = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Fournisseur = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $RefFourn = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $OldPrixV = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $OldPrixL = null;

    #[ORM\Column(nullable: true)]
    private ?float $OldPoids = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateChange = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $DateChangeInv = null;

    #[ORM\Column]
    private ?int $QteHs = null;

    #[ORM\Column]
    private ?int $QteAchat = null;

    #[ORM\Column]
    private ?int $Agence = null;

    #[ORM\Column]
    private ?int $QteLocTheorique = null;

    #[ORM\Column]
    private ?int $QteLocReelle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepot(): ?int
    {
        return $this->Depot;
    }

    public function setDepot(int $Depot): self
    {
        $this->Depot = $Depot;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->Article;
    }

    public function setArticle(string $Article): self
    {
        $this->Article = $Article;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->Designation;
    }

    public function setDesignation(string $Designation): self
    {
        $this->Designation = $Designation;

        return $this;
    }

    public function getPrixVente(): ?string
    {
        return $this->PrixVente;
    }

    public function setPrixVente(?string $PrixVente): self
    {
        $this->PrixVente = $PrixVente;

        return $this;
    }

    public function getPrixLoc(): ?string
    {
        return $this->PrixLoc;
    }

    public function setPrixLoc(?string $PrixLoc): self
    {
        $this->PrixLoc = $PrixLoc;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->Poids;
    }

    public function setPoids(float $Poids): self
    {
        $this->Poids = $Poids;

        return $this;
    }

    public function isVente(): ?bool
    {
        return $this->Vente;
    }

    public function setVente(bool $Vente): self
    {
        $this->Vente = $Vente;

        return $this;
    }

    public function isLocation(): ?bool
    {
        return $this->Location;
    }

    public function setLocation(bool $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function isConsommable(): ?bool
    {
        return $this->Consommable;
    }

    public function setConsommable(bool $Consommable): self
    {
        $this->Consommable = $Consommable;

        return $this;
    }

    public function isConditionnement(): ?bool
    {
        return $this->Conditionnement;
    }

    public function setConditionnement(bool $Conditionnement): self
    {
        $this->Conditionnement = $Conditionnement;

        return $this;
    }

    public function getQteTotale(): ?int
    {
        return $this->QteTotale;
    }

    public function setQteTotale(int $QteTotale): self
    {
        $this->QteTotale = $QteTotale;

        return $this;
    }

    public function getQteDispo(): ?int
    {
        return $this->QteDispo;
    }

    public function setQteDispo(int $QteDispo): self
    {
        $this->QteDispo = $QteDispo;

        return $this;
    }

    public function getQteSortie(): ?int
    {
        return $this->QteSortie;
    }

    public function setQteSortie(int $QteSortie): self
    {
        $this->QteSortie = $QteSortie;

        return $this;
    }

    public function getQteReserve(): ?int
    {
        return $this->QteReserve;
    }

    public function setQteReserve(int $QteReserve): self
    {
        $this->QteReserve = $QteReserve;

        return $this;
    }

    public function getQteTransit(): ?int
    {
        return $this->QteTransit;
    }

    public function setQteTransit(int $QteTransit): self
    {
        $this->QteTransit = $QteTransit;

        return $this;
    }

    public function getQteTemp(): ?int
    {
        return $this->QteTemp;
    }

    public function setQteTemp(int $QteTemp): self
    {
        $this->QteTemp = $QteTemp;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->DateAchat;
    }

    public function setDateAchat(?\DateTimeInterface $DateAchat): self
    {
        $this->DateAchat = $DateAchat;

        return $this;
    }

    public function getDateAchatInv(): ?string
    {
        return $this->DateAchatInv;
    }

    public function setDateAchatInv(?string $DateAchatInv): self
    {
        $this->DateAchatInv = $DateAchatInv;

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

    public function getDateSaisie(): ?\DateTimeInterface
    {
        return $this->DateSaisie;
    }

    public function setDateSaisie(?\DateTimeInterface $DateSaisie): self
    {
        $this->DateSaisie = $DateSaisie;

        return $this;
    }

    public function getDateSaisieInv(): ?string
    {
        return $this->DateSaisieInv;
    }

    public function setDateSaisieInv(?string $DateSaisieInv): self
    {
        $this->DateSaisieInv = $DateSaisieInv;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->Emplacement;
    }

    public function setEmplacement(?string $Emplacement): self
    {
        $this->Emplacement = $Emplacement;

        return $this;
    }

    public function getImage()
    {
        return $this->Image;
    }

    public function setImage($Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function isAControler(): ?bool
    {
        return $this->AControler;
    }

    public function setAControler(bool $AControler): self
    {
        $this->AControler = $AControler;

        return $this;
    }

    public function getFournisseur(): ?string
    {
        return $this->Fournisseur;
    }

    public function setFournisseur(?string $Fournisseur): self
    {
        $this->Fournisseur = $Fournisseur;

        return $this;
    }

    public function getRefFourn(): ?string
    {
        return $this->RefFourn;
    }

    public function setRefFourn(?string $RefFourn): self
    {
        $this->RefFourn = $RefFourn;

        return $this;
    }

    public function getOldPrixV(): ?string
    {
        return $this->OldPrixV;
    }

    public function setOldPrixV(string $OldPrixV): self
    {
        $this->OldPrixV = $OldPrixV;

        return $this;
    }

    public function getOldPrixL(): ?string
    {
        return $this->OldPrixL;
    }

    public function setOldPrixL(string $OldPrixL): self
    {
        $this->OldPrixL = $OldPrixL;

        return $this;
    }

    public function getOldPoids(): ?float
    {
        return $this->OldPoids;
    }

    public function setOldPoids(?float $OldPoids): self
    {
        $this->OldPoids = $OldPoids;

        return $this;
    }

    public function getDateChange(): ?\DateTimeInterface
    {
        return $this->DateChange;
    }

    public function setDateChange(?\DateTimeInterface $DateChange): self
    {
        $this->DateChange = $DateChange;

        return $this;
    }

    public function getDateChangeInv(): ?string
    {
        return $this->DateChangeInv;
    }

    public function setDateChangeInv(?string $DateChangeInv): self
    {
        $this->DateChangeInv = $DateChangeInv;

        return $this;
    }

    public function getQteHs(): ?int
    {
        return $this->QteHs;
    }

    public function setQteHs(int $QteHs): self
    {
        $this->QteHs = $QteHs;

        return $this;
    }

    public function getQteAchat(): ?int
    {
        return $this->QteAchat;
    }

    public function setQteAchat(int $QteAchat): self
    {
        $this->QteAchat = $QteAchat;

        return $this;
    }

    public function getAgence(): ?int
    {
        return $this->Agence;
    }

    public function setAgence(int $Agence): self
    {
        $this->Agence = $Agence;

        return $this;
    }

    public function getQteLocTheorique(): ?int
    {
        return $this->QteLocTheorique;
    }

    public function setQteLocTheorique(int $QteLocTheorique): self
    {
        $this->QteLocTheorique = $QteLocTheorique;

        return $this;
    }

    public function getQteLocReelle(): ?int
    {
        return $this->QteLocReelle;
    }

    public function setQteLocReelle(int $QteLocReelle): self
    {
        $this->QteLocReelle = $QteLocReelle;

        return $this;
    }
}
