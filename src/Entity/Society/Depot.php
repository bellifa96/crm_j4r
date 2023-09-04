<?php

namespace App\Entity\Society;

use App\Repository\Society\DepotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepotRepository::class)]
class Depot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $CodeDepot = null;

    #[ORM\Column(length: 255)]
    private ?string $NomDepot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeDepot(): ?int
    {
        return $this->CodeDepot;
    }

    public function setCodeDepot(int $CodeDepot): self
    {
        $this->CodeDepot = $CodeDepot;

        return $this;
    }

    public function getNomDepot(): ?string
    {
        return $this->NomDepot;
    }

    public function setNomDepot(string $NomDepot): self
    {
        $this->NomDepot = $NomDepot;

        return $this;
    }
}
