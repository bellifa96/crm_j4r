<?php

namespace App\Entity\Conversation;

use App\Entity\TimesTrait;
use App\Entity\User;
use App\Repository\Conversation\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    use TimesTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $message;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    private $createur;

    #[ORM\ManyToOne(targetEntity: ConversationMetreDemande::class, inversedBy: 'messages')]
    private $conversationDemandeMetre;


    #[ORM\ManyToOne(targetEntity: ConversationApresNegociationDemande::class, inversedBy: 'messages')]
    private $conversationApresNegociationDemande;

    #[ORM\ManyToOne(targetEntity: ConversationClient::class, inversedBy: 'messages')]
    private $conversationClient;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getConversationDemandeMetre(): ?ConversationMetreDemande
    {
        return $this->conversationDemandeMetre;
    }

    public function setConversationDemandeMetre(?ConversationMetreDemande $conversationDemandeMetre): self
    {
        $this->conversationDemandeMetre = $conversationDemandeMetre;

        return $this;
    }

    public function getConversationApresNegociationDemande(): ?ConversationApresNegociationDemande
    {
        return $this->conversationApresNegociationDemande;
    }

    public function setConversationApresNegociationDemande(?ConversationApresNegociationDemande $conversationApresNegociationDemande): self
    {
        $this->conversationApresNegociationDemande = $conversationApresNegociationDemande;

        return $this;
    }

    public function getConversationClient(): ?ConversationClient
    {
        return $this->conversationClient;
    }

    public function setConversationClient(?ConversationClient $conversationClient): self
    {
        $this->conversationClient = $conversationClient;

        return $this;
    }

}
