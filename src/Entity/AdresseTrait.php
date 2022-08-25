<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


Trait AdresseTrait
{

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $adresse1;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $adresse2;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $ville;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $codePostal;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $pays;


    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(?string $adresse1): self
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }
}
