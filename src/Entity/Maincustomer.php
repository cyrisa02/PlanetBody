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

    

    #[ORM\OneToOne(mappedBy: 'maincustomer', cascade: ['persist', 'remove'])]
    private ?User $user = null;

        public function __toString()
     {
       return $this->id;
     }

    public function getId(): ?int
    {
        return $this->id;
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

    

    
    
}