<?php

namespace App\Entity;

use App\Repository\SentmailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SentmailRepository::class)]
class Sentmail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'sentmails')]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'sentmails')]
    private ?Mailing $mailings = null;

    /**
 	*This constructor is for the date
 	*/
 	public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getMailings(): ?Mailing
    {
        return $this->mailings;
    }

    public function setMailings(?Mailing $mailings): self
    {
        $this->mailings = $mailings;

        return $this;
    }
}