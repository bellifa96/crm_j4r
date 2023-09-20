<?php

namespace App\Entity\Conversation;

use App\Entity\Demande;
use App\Repository\Conversation\ConversationApresNegociationDemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConversationApresNegociationDemandeRepository::class)]
class ConversationApresNegociationDemande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'conversationApresNegociationDemande', targetEntity: Demande::class, cascade: ['persist', 'remove'])]
    private $demande;

    #[ORM\OneToMany(mappedBy: 'conversationApresNegociationDemande', targetEntity: Message::class)]
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
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


    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversationApresNegociationDemande($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getConversationApresNegociationDemande() === $this) {
                $message->setConversationApresNegociationDemande(null);
            }
        }

        return $this;
    }

}
