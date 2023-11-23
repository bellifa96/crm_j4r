<?php

namespace App\Entity\Depot;

use App\Repository\Depot\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;



class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $idarticles;

    #[ORM\Column(type: 'string')]

    private $article = '';

    #[ORM\Column(type: 'string')]
    private $designation = '';

    #[ORM\Column(type: 'decimal')]

    private $prixvente = '0.00';

    #[ORM\Column(type: 'decimal')]
    private $prixloc = '0.00';

    #[ORM\Column(type: 'float')]
    private $poids = '0';

    #[ORM\Column(type: 'boolean')]
    private $vente = '0';

    #[ORM\Column(type: 'boolean')]

    private $location = '0';

    #[ORM\Column(type: 'boolean')]

    private $consommable = '0';

    #[ORM\Column(type: 'boolean')]

    private $conditionnement = '0';

    #[ORM\Column(type: 'integer')]

    private $qtetotale = '0';

    #[ORM\Column(type: 'integer')]

    private $qtedispo = '0';

    #[ORM\Column(type: 'integer')]

    private $qtesortie = '0';

    #[ORM\Column(type: 'integer')]

    private $qtereserve = '0';

    #[ORM\Column(type: 'integer')]

    private $qtetransit = '0';

    #[ORM\Column(type: 'integer')]

    private $qtetemp = '0';

    #[ORM\Column(type: 'date')]

    private $dateachat;

    #[ORM\Column(type: 'date')]

    private $dateachatinv = '';

    #[ORM\Column(type: 'string')]

    private $commentaires = '';

    #[ORM\Column(type: 'date')]
    private $datesaisie;

    #[ORM\Column(type: 'string')]
    private $datesaisieinv = '';

     #[ORM\Column(type: 'string')]
    private $emplacement = '';

    #[ORM\Column(type: 'blob')]

    private $image;

    #[ORM\Column(type: 'boolean')]
    private $acontroler = '0';

    #[ORM\Column(type: 'string')]

    private $fournisseur = '';

    #[ORM\Column(type: 'string')]

    private $reffourn = '';

    #[ORM\Column(type: 'decimal')]

    private $oldprixv = '0.00';

    #[ORM\Column(type: 'decimal')]

    private $oldprixl = '0.00';

    #[ORM\Column(type: 'float')]

    private $oldpoids = '0';

    #[ORM\Column(type: 'date')]

    private $datechange;

    #[ORM\Column(type: 'string')]

    private $datechangeinv = '';

    #[ORM\Column(type: 'integer')]

    private $qtehs = '0';

    #[ORM\Column(type: 'integer')]

    private $qteachat = '0';

    #[ORM\Column(type: 'integer')]

    private $qteloctheorique = '0';

    #[ORM\Column(type: 'integer')]

    private $qtelocreelle = '0';

    #[ORM\ManyToOne(targetEntity:Depot::class, inversedBy: 'depots')]
    #[ORM\JoinColumn(name:'iddepot', referencedColumnName:'iddepot')]
    private $depot;

    #[ORM\ManyToOne(targetEntity:Agence::class, inversedBy: 'agences')]
    #[ORM\JoinColumn(name:'idagence', referencedColumnName:'idagence')]
    private $idagence;

    public function getIdarticles(): ?string
    {
        return $this->idarticles;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(?string $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrixvente(): ?string
    {
        return $this->prixvente;
    }

    public function setPrixvente(?string $prixvente): static
    {
        $this->prixvente = $prixvente;

        return $this;
    }

    public function getPrixloc(): ?string
    {
        return $this->prixloc;
    }

    public function setPrixloc(?string $prixloc): static
    {
        $this->prixloc = $prixloc;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function isVente(): ?bool
    {
        return $this->vente;
    }

    public function setVente(?bool $vente): static
    {
        $this->vente = $vente;

        return $this;
    }

    public function isLocation(): ?bool
    {
        return $this->location;
    }

    public function setLocation(?bool $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function isConsommable(): ?bool
    {
        return $this->consommable;
    }

    public function setConsommable(?bool $consommable): static
    {
        $this->consommable = $consommable;

        return $this;
    }

    public function isConditionnement(): ?bool
    {
        return $this->conditionnement;
    }

    public function setConditionnement(?bool $conditionnement): static
    {
        $this->conditionnement = $conditionnement;

        return $this;
    }

    public function getQtetotale(): ?int
    {
        return $this->qtetotale;
    }

    public function setQtetotale(?int $qtetotale): static
    {
        $this->qtetotale = $qtetotale;

        return $this;
    }

    public function getQtedispo(): ?int
    {
        return $this->qtedispo;
    }

    public function setQtedispo(?int $qtedispo): static
    {
        $this->qtedispo = $qtedispo;

        return $this;
    }

    public function getQtesortie(): ?int
    {
        return $this->qtesortie;
    }

    public function setQtesortie(?int $qtesortie): static
    {
        $this->qtesortie = $qtesortie;

        return $this;
    }

    public function getQtereserve(): ?int
    {
        return $this->qtereserve;
    }

    public function setQtereserve(?int $qtereserve): static
    {
        $this->qtereserve = $qtereserve;

        return $this;
    }

    public function getQtetransit(): ?int
    {
        return $this->qtetransit;
    }

    public function setQtetransit(?int $qtetransit): static
    {
        $this->qtetransit = $qtetransit;

        return $this;
    }

    public function getQtetemp(): ?int
    {
        return $this->qtetemp;
    }

    public function setQtetemp(?int $qtetemp): static
    {
        $this->qtetemp = $qtetemp;

        return $this;
    }

    public function getDateachat(): ?\DateTimeInterface
    {
        return $this->dateachat;
    }

    public function setDateachat(?\DateTimeInterface $dateachat): static
    {
        $this->dateachat = $dateachat;

        return $this;
    }

    public function getDateachatinv(): ?string
    {
        return $this->dateachatinv;
    }

    public function setDateachatinv(?string $dateachatinv): static
    {
        $this->dateachatinv = $dateachatinv;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getDatesaisie(): ?\DateTimeInterface
    {
        return $this->datesaisie;
    }

    public function setDatesaisie(?\DateTimeInterface $datesaisie): static
    {
        $this->datesaisie = $datesaisie;

        return $this;
    }

    public function getDatesaisieinv(): ?string
    {
        return $this->datesaisieinv;
    }

    public function setDatesaisieinv(?string $datesaisieinv): static
    {
        $this->datesaisieinv = $datesaisieinv;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(?string $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isAcontroler(): ?bool
    {
        return $this->acontroler;
    }

    public function setAcontroler(?bool $acontroler): static
    {
        $this->acontroler = $acontroler;

        return $this;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?string $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getReffourn(): ?string
    {
        return $this->reffourn;
    }

    public function setReffourn(?string $reffourn): static
    {
        $this->reffourn = $reffourn;

        return $this;
    }

    public function getOldprixv(): ?string
    {
        return $this->oldprixv;
    }

    public function setOldprixv(?string $oldprixv): static
    {
        $this->oldprixv = $oldprixv;

        return $this;
    }

    public function getOldprixl(): ?string
    {
        return $this->oldprixl;
    }

    public function setOldprixl(?string $oldprixl): static
    {
        $this->oldprixl = $oldprixl;

        return $this;
    }

    public function getOldpoids(): ?float
    {
        return $this->oldpoids;
    }

    public function setOldpoids(?float $oldpoids): static
    {
        $this->oldpoids = $oldpoids;

        return $this;
    }

    public function getDatechange(): ?\DateTimeInterface
    {
        return $this->datechange;
    }

    public function setDatechange(?\DateTimeInterface $datechange): static
    {
        $this->datechange = $datechange;

        return $this;
    }

    public function getDatechangeinv(): ?string
    {
        return $this->datechangeinv;
    }

    public function setDatechangeinv(?string $datechangeinv): static
    {
        $this->datechangeinv = $datechangeinv;

        return $this;
    }

    public function getQtehs(): ?int
    {
        return $this->qtehs;
    }

    public function setQtehs(?int $qtehs): static
    {
        $this->qtehs = $qtehs;

        return $this;
    }

    public function getQteachat(): ?int
    {
        return $this->qteachat;
    }

    public function setQteachat(?int $qteachat): static
    {
        $this->qteachat = $qteachat;

        return $this;
    }

    public function getQteloctheorique(): ?int
    {
        return $this->qteloctheorique;
    }

    public function setQteloctheorique(?int $qteloctheorique): static
    {
        $this->qteloctheorique = $qteloctheorique;

        return $this;
    }

    public function getQtelocreelle(): ?int
    {
        return $this->qtelocreelle;
    }

    public function setQtelocreelle(?int $qtelocreelle): static
    {
        $this->qtelocreelle = $qtelocreelle;

        return $this;
    }

    public function getDepot(): ?Depot
    {
        return $this->depot;
    }

    public function setDepot(?Depot $depot): static
    {
        $this->depot = $depot;

        return $this;
    }

    public function getIdagence(): ?Agence
    {
        return $this->idagence;
    }

    public function setIdagence(?Agence $idagence): static
    {
        $this->idagence = $idagence;

        return $this;
    }


}
