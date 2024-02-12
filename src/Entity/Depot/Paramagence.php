<?php

namespace App\Entity\Depot;

use App\Repository\Depot\ParamAgenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParamAgenceRepository::class)]

class Paramagence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private $idparam;

    #[ORM\Column(type: 'integer')]

    private $idagence;

    #[ORM\Column(type: 'integer')]

    private $numbl;

    #[ORM\Column(type: 'integer')]

    private $numbr;

    #[ORM\Column(type: 'integer')]

    private $numbv;

    #[ORM\Column(type: 'integer')]

    private $numac;

    #[ORM\Column(type: 'integer')]

    private $tva;

    #[ORM\Column(type: 'string')]
    private $accesstoken;

    #[ORM\Column(type: 'integer')]

    private $expiretoken;

    #[ORM\Column(type: 'date')]
    private $dateheure;
    public function getIdparam(): ?int
    {
        return $this->idparam;
    }

    public function setIdparam(int $idparam): self
    {
        $this->idparam = $idparam;

        return $this;
    }

    public function getIdagence(): ?int
    {
        return $this->idagence;
    }

    public function setIdagence(int $idagence): self
    {
        $this->idagence = $idagence;

        return $this;
    }

    public function getNumbl(): ?int
    {
        return $this->numbl;
    }

    public function setNumbl(int $numbl): self
    {
        $this->numbl = $numbl;

        return $this;
    }

    public function getNumbr(): ?int
    {
        return $this->numbr;
    }

    public function setNumbr(int $numbr): self
    {
        $this->numbr = $numbr;

        return $this;
    }

    public function getNumbv(): ?int
    {
        return $this->numbv;
    }

    public function setNumbv(int $numbv): self
    {
        $this->numbv = $numbv;

        return $this;
    }

    public function getNumac(): ?int
    {
        return $this->numac;
    }

    public function setNumac(int $numac): self
    {
        $this->numac = $numac;

        return $this;
    }

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getAccesstoken(): ?string
    {
        return $this->accesstoken;
    }

    public function setAccesstoken(string $accesstoken): self
    {
        $this->accesstoken = $accesstoken;

        return $this;
    }

    public function getExpiretoken(): ?int
    {
        return $this->expiretoken;
    }

    public function setExpiretoken(int $expiretoken): self
    {
        $this->expiretoken = $expiretoken;

        return $this;
    }

    public function getDateheure(): ?\DateTimeInterface
    {
        return $this->dateheure;
    }

    public function setDateheure(\DateTimeInterface $dateheure): self
    {
        $this->dateheure = $dateheure;

        return $this;
    }

}
