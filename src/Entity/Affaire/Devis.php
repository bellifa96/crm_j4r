<?php

namespace App\Entity\Affaire;

use App\Entity\Demande;
use App\Entity\TimesTrait;
use App\Entity\User;
use App\Entity\Conversation\ConversationChantier;
use App\Repository\Affaire\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
#[Gedmo\Loggable]
class Devis
{

    use TimesTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Demande::class, inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    private $demande;

    #[Gedmo\Versioned]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numero;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $dateDuDevis;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $statut;

    #[ORM\Column(type:'array', nullable: true)]
    private $elements = [];

    #[ORM\Column(nullable: true)]
    private ?float $debourseTotalHT = null;

    #[ORM\ManyToOne(inversedBy: 'devisCreateur')]
    private ?User $createur = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'devis')]
    private Collection $referent;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateRelance = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireChantier = null;

    #[ORM\OneToOne(mappedBy: 'devis', targetEntity: ConversationChantier::class, cascade: ['persist', 'remove'])]
    private $conversationChantier;

    #[ORM\Column(nullable: true)]
    private ?float $margeBeneficiaire = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixDeVenteHT = null;

    #[ORM\Column(nullable: true)]
    private ?float $fraisGeneraux = null;

    #[ORM\OneToMany(mappedBy: 'devis', targetEntity: Lot::class, cascade: ['remove'])]
    private Collection $lots;

    #[ORM\OneToMany(mappedBy: 'devis', targetEntity: Ouvrage::class, cascade: ['remove'])]
    private Collection $ouvrages;

    #[ORM\Column(nullable: true)]
    private ?float $marge = null;

    #[ORM\Column(nullable: true)]
    private ?float $tva = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observations = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designationDesTravaux = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaireInterne = null;

    public function __construct(){
        $this->dateDuDevis = date('d/m/Y');
        $this->statut = "Brouillon";
        $this->referent = new ArrayCollection();
        $this->lots = new ArrayCollection();
        $this->ouvrages = new ArrayCollection();
        $this->marge = 1.4;
        $this->tva = 20;
    }


    public function __toArray(){
        return [
            'id'=>$this->id,
            'marge'=>$this->marge,
            'prixDeVenteHT'=>$this->prixDeVenteHT,
            'debourseTotalHT'=>$this->debourseTotalHT,
            'tva'=>$this->tva,
            'type'=>'devis',
        ];
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

    public function getSommePrixDeVenteHTLots(){
        $sum = 0;
        foreach($this->lots as $lot){
             $sum += $lot->getPrixDeVenteHT();
        }
        return $sum;
    }

    public function getSommeDebourseTotalLots(){
        $sum = 0;

        foreach($this->lots as $lot){
            if(empty($lot->debourseTotalLot) && (!empty($lot->getOuvrages()) || !empty($lot->getSousLots()))){
                $lot->SetDebourseTotalLot($lot->getSommeDebourseTotalSousLots()+ $lot->getSommeDebourseTotalOuvrages());
            }
            $sum += $lot->getDebourseTotalLot();
        }
        return $sum;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?Demande
    {

        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDuDevis(): ?string
    {
        return $this->dateDuDevis;
    }

    public function setDateDuDevis(string $dateDuDevis): self
    {
        $this->dateDuDevis = $dateDuDevis;

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

    public function getElements(): ?array
    {
        return $this->elements;
    }

    public function setElements(?array $elements): self
    {
        $this->elements = $elements;

        return $this;
    }

    public function inElements($el,$elements=null):bool
    {

        if(empty($elements)){
            $elements = $this->elements;
        }
        foreach($elements as $element){
            if($element['id']==$el['id'] && $element['type']== $el['type']){
                return true;
            }elseif(!empty($element['data'])){
                $this->inElements($el,$element['data']);
            }
        }
        return false;
    }

    public function deleteInElements($el, $lotRepository, $ouvrageRepository, $composantRepository, $elements=null)
    {
        if(empty($elements)){
            $elements = $this->elements;
        }
        //dd($elements, $el);
        foreach($elements as $key=>$element){
            if($element['id']==$el['id'] && $element['type']== $el['type']){
             //   dd( $element, $el);
                if(!empty($element['data'])){
                    foreach($element['data'] as $elEnfant){
                        $this->deleteInElements($elEnfant, $lotRepository, $ouvrageRepository, $composantRepository, $element['data']);
                    }
                }
                if ($element['type']== 'lot'){
                    $lot = $lotRepository->find($element['id']);
                    $lotRepository->remove($lot);
                }elseif ($element['type']== 'ouvrage'){
                    $ouvrage = $ouvrageRepository->find($element['id']);
                    $ouvrageRepository->remove($ouvrage);
                }elseif($element['type'] == 'composant'){
                  //  dd($element);
                    $composant = $composantRepository->find($element['id']);
                    $composantRepository->remove($composant);
                }
                unset($elements[$key]);
            }else if(!empty($element['data'])){
                $elements[$key]['data'] = $this->deleteInElements($el, $lotRepository, $ouvrageRepository, $composantRepository, $element['data']);
            }
        }
        return $elements;
    }

    public function getDebourseTotalHT(): ?float
    {
        return $this->debourseTotalHT;
    }

    public function setDebourseTotalHT(?float $debourseTotalHT): self
    {
        $this->debourseTotalHT = $debourseTotalHT;

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

    /**
     * @return Collection<int, User>
     */
    public function getReferent(): Collection
    {
        return $this->referent;
    }

    public function addReferent(User $referent): self
    {
        if (!$this->referent->contains($referent)) {
            $this->referent->add($referent);
        }

        return $this;
    }

    public function removeReferent(User $referent): self
    {
        $this->referent->removeElement($referent);

        return $this;
    }

    public function getDateRelance(): ?string
    {
        return $this->dateRelance;
    }

    public function setDateRelance(?string $dateRelance): self
    {
        $this->dateRelance = $dateRelance;

        return $this;
    }

    public function getCommentaireChantier(): ?string
    {
        return $this->commentaireChantier;
    }

    public function setCommentaireChantier(?string $commentaireChantier): self
    {
        $this->commentaireChantier = $commentaireChantier;

        return $this;
    }

    public function getConversationChantier(): ?ConversationChantier
    {
        return $this->conversationChantier;
    }

    public function setConversationChantier(?ConversationChantier $conversationChantier): self
    {
        // unset the owning side of the relation if necessary
        if ($conversationChantier === null && $this->conversationChantier !== null) {
            $this->conversationChantier->setDemande(null);
        }

        // set the owning side of the relation if necessary
        if ($conversationChantier !== null && $conversationChantier->getDemande() !== $this) {
            $conversationChantier->setDemande($this);
        }

        $this->conversationChantier = $conversationChantier;

        return $this;
    }

    public function getMargeBeneficiaire(): ?float
    {
        return $this->margeBeneficiaire;
    }

    public function setMargeBeneficiaire(?float $margeBeneficiaire): self
    {
        $this->margeBeneficiaire = $margeBeneficiaire;

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

    public function getFraisGeneraux(): ?float
    {
        return $this->fraisGeneraux;
    }

    public function setFraisGeneraux(?float $fraisGeneraux): self
    {
        $this->fraisGeneraux = $fraisGeneraux;

        return $this;
    }

    /**
     * @return Collection<int, Lot>
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): self
    {
        if (!$this->lots->contains($lot)) {
            $this->lots->add($lot);
            $lot->setDevis($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): self
    {
        if ($this->lots->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getDevis() === $this) {
                $lot->setDevis(null);
            }
        }

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
            $ouvrage->setDevis($this);
        }

        return $this;
    }

    public function removeOuvrage(Ouvrage $ouvrage): self
    {
        if ($this->ouvrages->removeElement($ouvrage)) {
            // set the owning side to null (unless already changed)
            if ($ouvrage->getDevis() === $this) {
                $ouvrage->setDevis(null);
            }
        }

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

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }

    public function getDesignationDesTravaux(): ?string
    {
        return $this->designationDesTravaux;
    }

    public function setDesignationDesTravaux(?string $designationDesTravaux): self
    {
        $this->designationDesTravaux = $designationDesTravaux;

        return $this;
    }

    public function getCommentaireInterne(): ?string
    {
        return $this->commentaireInterne;
    }

    public function setCommentaireInterne(?string $commentaireInterne): self
    {
        $this->commentaireInterne = $commentaireInterne;

        return $this;
    }

}
