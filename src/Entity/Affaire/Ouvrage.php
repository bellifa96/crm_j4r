<?php

namespace App\Entity\Affaire;

use App\Entity\TimesTrait;
use App\Entity\User;
use App\Entity\Unite;
use App\Repository\Affaire\OuvrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: OuvrageRepository::class)]
#[Gedmo\Loggable]
class Ouvrage
{
    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $denomination;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $typeDOuvrage;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    #[Gedmo\Versioned]
    private $code;

    #[ORM\Column(type: 'float',nullable: true)]
    #[Gedmo\Versioned]
    private $prixUnitaireDebourse;

    #[ORM\Column(type: 'integer',nullable: true)]
    #[Gedmo\Versioned]
    private $quantite;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Gedmo\Versioned]
    private $debourseHTCalcule;

    #[ORM\Column(type: 'float',nullable: true)]
    #[Gedmo\Versioned]
    private $marge;

    #[ORM\Column(type: 'float',nullable: true)]
    #[Gedmo\Versioned]
    private $prixDeVenteHT;

    #[ORM\ManyToOne(targetEntity: Lot::class, inversedBy: 'ouvrages')]
    private $lot;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ouvrages')]
    private $createur;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Gedmo\Versioned]
    private $note;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $statut;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $origine = null;

    #[ORM\ManyToOne]
    private ?Unite $unite = null;

    #[ORM\OneToMany(mappedBy: 'ouvrage', targetEntity: Composant::class, cascade:['remove'])]
    private Collection $composants;

    public function __construct()
    {
        $this->quantite = 1;
        $this->composants = new ArrayCollection();
    }

    public function __toArray(){
        return [
           "id"=> $this->id,
           "denomination"=> $this->denomination,
           "typeDOuvrage"=> $this->typeDOuvrage,
           "code"=> $this->code,
           "marge"=> $this->marge,
           "unite"=> $this->unite,
           "origine"=> $this->origine,
           "note"=> $this->note,
           "quantite"=> $this->quantite,
           "margeMoyenneComposants"=> $this->getMargeMoyenneComposants(),
           'sommeDebourseTotalComposant' => $this->getSommeDebourseTotalComposants(),
           'sommePrixDeVenteHTComposants' => $this->getSommePrixDeVenteHTComposants()
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(?string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getTypeDOuvrage(): ?string
    {
        return $this->typeDOuvrage;
    }

    public function setTypeDOuvrage(?string $typeDOuvrage): self
    {
        $this->typeDOuvrage = $typeDOuvrage;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPrixUnitaireDebourse(): ?float
    {
        return $this->prixUnitaireDebourse;
    }

    // return la somme des prix unitaire HT des composants de l'ouvrage
    public function getSommeDebourseTotalComposants(){
        $sum = 0;
        foreach($this->composants as $composant){
             $sum += $composant->getQuantite() * $composant->getDebourseUnitaireHT();
        }
        return $sum;
    }

    public function getSommePrixDeVenteHTComposants(){
        $sum = 0;
        foreach($this->composants as $composant){
             $sum += $composant->getQuantite() * $composant->getDebourseUnitaireHT() * $composant->getMarge();
        }
        return $sum;
    }

    public function getMargeMoyenneComposants(){
        $sum = 0;
       foreach($this->composants as $composant){
             $sum += $composant->getMarge();
        }
        return $sum / count($this->composants) ;
    }

    public function setPrixUnitaireDebourse(float $prixUnitaireDebourse): self
    {
        $this->prixUnitaireDebourse = $prixUnitaireDebourse;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDebourseHTCalcule(): ?float
    {
        return $this->debourseHTCalcule;
    }

    public function setDebourseHTCalcule(float $debourseHTCalcule): self
    {
        $this->debourseHTCalcule = $debourseHTCalcule;

        return $this;
    }

    public function getMarge(): ?float
    {
        return $this->marge;
    }

    public function setMarge(?float $marge): self
    {
        $this->marge = $marge;

        return $this;
    }

    public function getPrixDeVenteHT(): ?float
    {
        return $this->prixDeVenteHT;
    }

    public function setPrixDeVenteHT(?float $prixDeVenteHT): self
    {
        $this->prixDeVenteHT = $prixDeVenteHT;

        return $this;
    }

    public function getLot(): ?Lot
    {
        return $this->lot;
    }

    public function setLot(?Lot $lot): self
    {
        $this->lot = $lot;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(?string $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * @return Collection<int, Composant>
     */
    public function getComposants(): Collection
    {
        return $this->composants;
    }

    public function addComposant(Composant $composant): self
    {
        if (!$this->composants->contains($composant)) {
            $this->composants->add($composant);
            $composant->setOuvrage($this);
        }

        return $this;
    }

    public function removeComposant(Composant $composant): self
    {
        if ($this->composants->removeElement($composant)) {
            // set the owning side to null (unless already changed)
            if ($composant->getOuvrage() === $this) {
                $composant->setOuvrage(null);
            }
        }

        return $this;
    }

}
