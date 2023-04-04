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
    private ?float $debourseHT = null;

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

    public function __construct(){
        $this->dateDuDevis = date('d/m/Y');
        $this->lots = new ArrayCollection();
        $this->statut = "Brouillon";
        $this->ouvrages = new ArrayCollection();
        $this->referent = new ArrayCollection();
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

    public function deleteInElements($el, $lotRepository, $ouvrageRepository, $elements=null)
    {
        if(empty($elements)){
            $elements = $this->elements;
        }
        //dd($elements, $el);
        foreach($elements as $key=>$element){
            if($element['id']==$el['id'] && $element['type']== $el['type']){
                //dd( $element, $el);
                if(!empty($element['data'])){
                    $this->deleteInElements($el, $lotRepository, $ouvrageRepository, $element['data']);
                }
                if ($element['type']== 'lot'){
                    $lot = $lotRepository->find($element['id']);
                    $lotRepository->remove($lot);
                }elseif ($element['type']== 'ouvrage'){
                    $ouvrage = $ouvrageRepository->find($element['id']);
                    $ouvrageRepository->remove($ouvrage);
                }
                unset($elements[$key]);
            }else if(!empty($element['data'])){
                $elements[$key]['data'] = $this->deleteInElements($el, $lotRepository, $ouvrageRepository, $element['data']);
            }
        }
        return $elements;
    }

    public function getDebourseHT(): ?float
    {
        return $this->debourseHT;
    }

    public function setDebourseHT(?float $debourseHT): self
    {
        $this->debourseHT = $debourseHT;

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

}
