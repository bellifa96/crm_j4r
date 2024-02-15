<?php

namespace App\Entity\Depot;

use App\Repository\Depot\MouvementsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MouvementsRepository::class)]
#[ORM\Table(name: "Mouvements")]
class Mouvements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $idmouvements;

    #[ORM\Column(type: 'string')]
    private $article;

    #[ORM\Column(type: 'string')]
    private $commentaires;

    #[ORM\Column(type: 'integer')]
    private $sens;

    
    #[ORM\Column(type: 'integer')]

    private $numdevis;

    #[ORM\Column(type: 'integer')]
    private $indice;

    #[ORM\Column(type: 'integer')]

    private $codechantier;

    #[ORM\Column(type: 'string')]

    private $numaffaire;

    #[ORM\Column(type: 'integer')]

    private $qteloclayher;

    #[ORM\Column(type: 'string')]

    private $numbonlayher;

    #[ORM\Column(type: 'string')]

    private $typemouvlayher;

    #[ORM\Column(type: 'integer')]

    private $numerp;

    #[ORM\Column(type: 'datetime')]

    private $datemouvlayher;

    #[ORM\Column(type: 'string')]

    private $datemouvlayherinv;

    #[ORM\Column(type: 'integer')]
    private $qtelocj4r;

    #[ORM\Column(type: 'string')]

    private $numbonj4r;

    #[ORM\Column(type: 'integer')]
    private $typemouvj4r;

    #[ORM\Column(type: 'date')]

    private $datemouvj4r;

    #[ORM\Column(type: 'string')]

    private $datemouvj4rinv;

    #[ORM\Column(type: 'boolean')]

    private $mvtvalide;

    #[ORM\Column(type: 'decimal')]

    private $prixvente;

    #[ORM\Column(type: 'decimal')]
    private $prixloc;

    #[ORM\Column(type: 'string')]
    private $numboncamion;

    #[ORM\Column(type: 'date')]

    private $datemouv;

    #[ORM\Column(type: 'string')]

    private $datemouvinv;

    #[ORM\ManyToOne(targetEntity:Agence::class, inversedBy: 'agences')]
    #[ORM\JoinColumn(name:'idagence', referencedColumnName:'idagence')]
    private $idagence;

    #[ORM\ManyToOne(targetEntity:Depot::class, inversedBy: 'depots')]
    #[ORM\JoinColumn(name:'iddepot', referencedColumnName:'iddepot')]
    private $iddepot;

    public function getIdmouvements(): ?int
    {
        return $this->idmouvements;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(string $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(string $commentaires): self
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getSens(): ?int
    {
        return $this->sens;
    }

    public function setSens(int $sens): self
    {
        $this->sens = $sens;

        return $this;
    }

    public function getNumdevis(): ?int
    {
        return $this->numdevis;
    }

    public function setNumdevis(int $numdevis): self
    {
        $this->numdevis = $numdevis;

        return $this;
    }

    public function getIndice(): ?int
    {
        return $this->indice;
    }

    public function setIndice(int $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getCodechantier(): ?int
    {
        return $this->codechantier;
    }

    public function setCodechantier(int $codechantier): self
    {
        $this->codechantier = $codechantier;

        return $this;
    }

    public function getNumaffaire(): ?string
    {
        return $this->numaffaire;
    }

    public function setNumaffaire(string $numaffaire): self
    {
        $this->numaffaire = $numaffaire;

        return $this;
    }

    public function getQteloclayher(): ?int
    {
        return $this->qteloclayher;
    }

    public function setQteloclayher(int $qteloclayher): self
    {
        $this->qteloclayher = $qteloclayher;

        return $this;
    }

    public function getNumbonlayher(): ?string
    {
        return $this->numbonlayher;
    }

    public function setNumbonlayher(string $numbonlayher): self
    {
        $this->numbonlayher = $numbonlayher;

        return $this;
    }

    public function getTypemouvlayher(): ?string
    {
        return $this->typemouvlayher;
    }

    public function setTypemouvlayher(string $typemouvlayher): self
    {
        $this->typemouvlayher = $typemouvlayher;

        return $this;
    }

    public function getNumerp(): ?int
    {
        return $this->numerp;
    }

    public function setNumerp(int $numerp): self
    {
        $this->numerp = $numerp;

        return $this;
    }

    public function getDatemouvlayher(): ?\DateTimeInterface
    {
        return $this->datemouvlayher;
    }

    public function setDatemouvlayher(\DateTimeInterface $datemouvlayher): self
    {
        $this->datemouvlayher = $datemouvlayher;

        return $this;
    }

    public function getDatemouvlayherinv(): ?string
    {
        return $this->datemouvlayherinv;
    }

    public function setDatemouvlayherinv(string $datemouvlayherinv): self
    {
        $this->datemouvlayherinv = $datemouvlayherinv;

        return $this;
    }

    public function getQtelocj4r(): ?int
    {
        return $this->qtelocj4r;
    }

    public function setQtelocj4r(int $qtelocj4r): self
    {
        $this->qtelocj4r = $qtelocj4r;

        return $this;
    }

    public function getNumbonj4r(): ?string
    {
        return $this->numbonj4r;
    }

    public function setNumbonj4r(string $numbonj4r): self
    {
        $this->numbonj4r = $numbonj4r;

        return $this;
    }

    public function getTypemouvj4r(): ?int
    {
        return $this->typemouvj4r;
    }

    public function setTypemouvj4r(int $typemouvj4r): self
    {
        $this->typemouvj4r = $typemouvj4r;

        return $this;
    }

    public function getDatemouvj4r(): ?\DateTimeInterface
    {
        return $this->datemouvj4r;
    }

    public function setDatemouvj4r(\DateTimeInterface $datemouvj4r): self
    {
        $this->datemouvj4r = $datemouvj4r;

        return $this;
    }

    public function getDatemouvj4rinv(): ?string
    {
        return $this->datemouvj4rinv;
    }

    public function setDatemouvj4rinv(string $datemouvj4rinv): self
    {
        $this->datemouvj4rinv = $datemouvj4rinv;

        return $this;
    }

    public function getMvtvalide(): ?bool
    {
        return $this->mvtvalide;
    }

    public function setMvtvalide(bool $mvtvalide): self
    {
        $this->mvtvalide = $mvtvalide;

        return $this;
    }

    public function getPrixvente(): ?string
    {
        return $this->prixvente;
    }

    public function setPrixvente(string $prixvente): self
    {
        $this->prixvente = $prixvente;

        return $this;
    }

    public function getPrixloc(): ?string
    {
        return $this->prixloc;
    }

    public function setPrixloc(string $prixloc): self
    {
        $this->prixloc = $prixloc;

        return $this;
    }

    public function getNumboncamion(): ?string
    {
        return $this->numboncamion;
    }

    public function setNumboncamion(string $numboncamion): self
    {
        $this->numboncamion = $numboncamion;

        return $this;
    }

    public function getDatemouv(): ?\DateTimeInterface
    {
        return $this->datemouv;
    }

    public function setDatemouv(\DateTimeInterface $datemouv): self
    {
        $this->datemouv = $datemouv;

        return $this;
    }

    public function getDatemouvinv(): ?string
    {
        return $this->datemouvinv;
    }

    public function setDatemouvinv(string $datemouvinv): self
    {
        $this->datemouvinv = $datemouvinv;

        return $this;
    }

    public function getIdagence(): ?Agence
    {
        return $this->idagence;
    }

    public function setIdagence(?Agence $idagence): self
    {
        $this->idagence = $idagence;

        return $this;
    }

    public function getIddepot(): ?Depot
    {
        return $this->iddepot;
    }

    public function setIddepot(?Depot $iddepot): self
    {
        $this->iddepot = $iddepot;

        return $this;
    }


}
