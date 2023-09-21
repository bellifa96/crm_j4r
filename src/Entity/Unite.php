<?php

namespace App\Entity;

use App\Entity\Affaire\AutreOuvrage;
use App\Repository\UniteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniteRepository::class)]
class Unite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255,nullable:true)]
    private ?string $uniteNormalisee = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniteNormalisee(): ?string
    {
        return $this->uniteNormalisee;
    }

    public function setUniteNormalisee(?string $uniteNormalisee): self
    {
        $this->uniteNormalisee = $uniteNormalisee;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
    public function __toString(){
        return $this->label;
    }
}
