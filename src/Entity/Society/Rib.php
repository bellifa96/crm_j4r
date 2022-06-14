<?php

namespace App\Entity\Society;

use App\Entity\TimesTrait;
use App\Repository\Society\RibRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RibRepository::class)]
class Rib
{

    use TimesTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255,unique: true)]
    private $iban;

    #[ORM\Column(type: 'string', length: 255)]
    private $bic;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(string $bic): self
    {
        $this->bic = $bic;

        return $this;
    }
}
