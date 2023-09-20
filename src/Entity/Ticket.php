<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"le nom de ticket ne peut pas etre vide !")]
    private $title;

    #[ORM\Column(type: 'string', length: 500)]
    #[Assert\NotBlank(message:"Description de ticket ne peut pas etre vide")]

    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $level;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private $creator;

    #[ORM\Column(type: 'string', length: 255)]
    private $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateTaken;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dateResolved;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ticketsAdmin')]
    private $admin;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $resolved;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private $complain;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private $commentary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateTaken(): ?string
    {
        return $this->dateTaken;
    }

    public function setDateTaken(?string $dateTaken): self
    {
        $this->dateTaken = $dateTaken;

        return $this;
    }

    public function getDateResolved(): ?string
    {
        return $this->dateResolved;
    }

    public function setDateResolved(?string $dateResolved): self
    {
        $this->dateResolved = $dateResolved;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getResolved(): ?bool
    {
        return $this->resolved;
    }

    public function setResolved(?bool $resolved): self
    {
        $this->resolved = $resolved;

        return $this;
    }

    public function getComplain(): ?string
    {
        return $this->complain;
    }

    public function setComplain(?string $complain): self
    {
        $this->complain = $complain;

        return $this;
    }

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): self
    {
        $this->commentary = $commentary;

        return $this;
    }
}
