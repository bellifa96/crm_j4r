<?php

namespace App\Entity\Affaire;

use App\Entity\TimesTrait;
use App\Entity\Unite;
use App\Entity\User;
use App\Repository\Affaire\LotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: LotRepository::class)]
#[Gedmo\Loggable]
class Lot
{
    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $denomination;

    #[Gedmo\Versioned]
    #[ORM\ManyToOne(targetEntity: User::class)]
    private $createur;

    #[ORM\Column(type: 'string', length: 255,nullable: true)]
    private $code;

    #[ORM\Column(nullable: true)]
    private ?float $prixDeVenteHT = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantite = null;

    #[ORM\Column(nullable: true)]
    private ?float $marge = null;

    #[ORM\ManyToOne]
    private ?Unite $unite = null;

    #[ORM\Column(nullable: true)]
    private ?float $debourseUnitaireHT = null;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: Ouvrage::class, cascade: ['remove'])]
    private Collection $ouvrages;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'sousLots')]
    private ?self $lot = null;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: self::class, cascade: ['remove'])]
    private Collection $sousLots;

    #[ORM\Column(nullable: true)]
    private ?float $debourseTotalLot = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    private ?Devis $devis = null;

    public function __construct()
    {
        $this->ouvrages = new ArrayCollection();
        $this->sousLots = new ArrayCollection();
    }

    public function __toArray(){
        return [
            'id'=> $this->id,
            'quantite'=> $this->quantite,
            'marge'=> $this->marge,
            'code'=> $this->code,
            'denomination'=> $this->denomination,
            'unite'=> $this->unite,
            'prixDeVenteHT'=> $this->prixDeVenteHT,
            'type'=>'lots',
            'debourseTotalHT'=> $this->debourseTotalLot,
            'souslot'=>$this->getSommeDebourseTotalSousLots(),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSommePrixDeVenteHTOuvrages(){
        $sum = 0;
        foreach($this->ouvrages as $ouvrage){
             $sum += $ouvrage->getPrixDeVenteHT();
        }
        return $sum;
    }

    public function getSommeDebourseTotalOuvrages(){
        $sum = 0;
        foreach($this->ouvrages as $ouvrage){
             $sum += $ouvrage->getSommeDebourseTotalComposants();
        }
        return $sum;
    }

    public function getSommePrixDeVenteHTSousLots(){
        $sum = 0;
        foreach($this->sousLots as $lot){
             $sum += $lot->prixDeVenteHT;
        }
        return $sum;
    }

    public function getSommeDebourseTotalSousLots(){
        $sum = 0;

        foreach($this->sousLots as $lot){
            if(empty($lot->debourseTotalLot) && (!empty($lot->getOuvrages()) || !empty($lot->getSousLots()))){
                $lot->SetDebourseTotalLot($lot->getSommeDebourseTotalSousLots()+ $lot->getSommeDebourseTotalOuvrages());
            }
             $sum += $lot->debourseTotalLot;

        }
        return $sum;
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

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

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

    public function getPrixDeVenteHT(): ?float
    {
        return $this->prixDeVenteHT;
    }

    public function setPrixDeVenteHT(?float $prixDeVenteHT): self
    {
        $this->prixDeVenteHT = $prixDeVenteHT;

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

    public function getMarge(): ?float
    {
        return $this->marge;
    }

    public function setMarge(?float $marge): self
    {
        $this->marge = $marge;

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

    public function getDebourseUnitaireHT(): ?float
    {
        return $this->debourseUnitaireHT;
    }

    public function setDebourseUnitaireHT(?float $debourseUnitaireHT): self
    {
        $this->debourseUnitaireHT = $debourseUnitaireHT;

        return $this;
    }

    /**
     * @return Collection<int, Ouvrage>
     */
    public function getOuvrages(): Collection
    {
        return $this->ouvrages;
    }

    public function addOuvrage(Ouvrage $ouvrage): self
    {
        if (!$this->ouvrages->contains($ouvrage)) {
            $this->ouvrages->add($ouvrage);
            $ouvrage->setLot($this);
        }

        return $this;
    }

    public function removeOuvrage(Ouvrage $ouvrage): self
    {
        if ($this->ouvrages->removeElement($ouvrage)) {
            // set the owning side to null (unless already changed)
            if ($ouvrage->getLot() === $this) {
                $ouvrage->setLot(null);
            }
        }

        return $this;
    }

    public function getLot(): ?self
    {
        return $this->lot;
    }

    public function setLot(?self $lot): self
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSousLots(): Collection
    {
        return $this->sousLots;
    }

    public function addSousLot(self $sousLot): self
    {
        if (!$this->sousLots->contains($sousLot)) {
            $this->sousLots->add($sousLot);
            $sousLot->setLot($this);
        }

        return $this;
    }

    public function removeSousLot(self $sousLot): self
    {
        if ($this->sousLots->removeElement($sousLot)) {
            // set the owning side to null (unless already changed)
            if ($sousLot->getLot() === $this) {
                $sousLot->setLot(null);
            }
        }

        return $this;
    }

    public function getDebourseTotalLot(): ?float
    {
        return $this->debourseTotalLot;
    }

    public function setDebourseTotalLot(?float $debourseTotalLot): self
    {
        $this->debourseTotalLot = $debourseTotalLot;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): self
    {
        $this->devis = $devis;

        return $this;
    }





}
