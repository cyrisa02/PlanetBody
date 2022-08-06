<?php

namespace App\Entity;

use App\Repository\MaincustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaincustomerRepository::class)]
class Maincustomer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 190)]
    private ?string $contact = null;

    #[ORM\OneToOne(mappedBy: 'maincustomer', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'maincustomers')]
    private ?Partner $partners = null;

    

    
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setMaincustomer(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getMaincustomer() !== $this) {
            $user->setMaincustomer($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getPartners(): ?Partner
    {
        return $this->partners;
    }

    public function setPartners(?Partner $partners): self
    {
        $this->partners = $partners;

        return $this;
    }

    
    
}