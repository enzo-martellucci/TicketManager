<?php

namespace App\Entity;

use App\Config\Status;
use App\Repository\TicketStatusHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketStatusHistoryRepository::class)]
class TicketStatusHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ticket $ticket_id = null;

    #[ORM\Column(enumType: Status::class)]
    private ?Status $status = null;

    #[ORM\ManyToOne]
    private ?User $changed_by = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $changed_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketId(): ?Ticket
    {
        return $this->ticket_id;
    }

    public function setTicketId(?Ticket $ticket_id): static
    {
        $this->ticket_id = $ticket_id;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getChangedBy(): ?User
    {
        return $this->changed_by;
    }

    public function setChangedBy(?User $changed_by): static
    {
        $this->changed_by = $changed_by;

        return $this;
    }

    public function getChangedAt(): ?\DateTimeImmutable
    {
        return $this->changed_at;
    }

    public function setChangedAt(\DateTimeImmutable $changed_at): static
    {
        $this->changed_at = $changed_at;

        return $this;
    }
}
