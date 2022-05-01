<?php

namespace App\Entity\Ged;

use App\Entity\TimesTrait;
use App\Entity\User;
use App\Repository\Ged\FichierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichierRepository::class)]
class Fichier
{
    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $fichier;

    #[ORM\Column(type: 'boolean')]
    private $isDeleted;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'fichiers')]
    private $createur;

    #[ORM\ManyToOne(targetEntity: TypeFichier::class, inversedBy: 'fichiers')]
    #[ORM\JoinColumn(nullable: false)]
    private $typeFichier;

    public function __construct(){
        $this->isDeleted = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getTypeFichier(): ?TypeFichier
    {
        return $this->typeFichier;
    }

    public function setTypeFichier(?TypeFichier $typeFichier): self
    {
        $this->typeFichier = $typeFichier;

        return $this;
    }
}
