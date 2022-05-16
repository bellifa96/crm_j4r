<?php

namespace App\Entity\Interlocuteur;

use App\Entity\Contact\Contact;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterlocuteurRepository::class)]
class Interlocuteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\OneToOne(inversedBy: 'interlocuteur', targetEntity: Personne::class, cascade: ['persist', 'remove'])]
    private $personne;

    #[ORM\OneToOne(inversedBy: 'interlocuteur', targetEntity: Societe::class, cascade: ['persist', 'remove'])]
    private $societe;

    #[ORM\Column(type: 'array', nullable: true)]
    private $phone = [];

    #[ORM\OneToMany(mappedBy: 'societe', targetEntity: Contact::class)]
    private $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getSociete(): ?Societe
    {
        return $this->societe;
    }

    public function setSociete(?Societe $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getPhone(): ?array
    {
        return $this->phone;
    }

    public function setPhone(?array $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setSociete($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getSociete() === $this) {
                $contact->setSociete(null);
            }
        }

        return $this;
    }
}
