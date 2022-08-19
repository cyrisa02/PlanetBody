<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\Column(length: 190)]
    private ?string $contract = null;

    
    
    
    
    #[ORM\ManyToMany(targetEntity: Permission::class, inversedBy: 'partners')]
    private Collection $permissions;

    #[ORM\ManyToMany(targetEntity: Mailing::class, inversedBy: 'partners')]
    private Collection $mailings;

    #[ORM\OneToOne(mappedBy: 'partners', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'partners', targetEntity: Sporthall::class)]
    private Collection $sporthalls;

    #[ORM\Column]
    private ?bool $isEnable = false;

    

    
    public function __construct()
    {
        
        
        $this->permissions = new ArrayCollection();
        $this->mailings = new ArrayCollection();
        $this->sporthalls = new ArrayCollection();
    }
public function __toString()
     {
       return $this->contract;
     }
    

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    
   

    

    /**
     * @return Collection<int, Permission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions->add($permission);
        }

        return $this;
    }

    public function removePermission(Permission $permission): self
    {
        $this->permissions->removeElement($permission);

        return $this;
    }

    /**
     * @return Collection<int, Mailing>
     */
    public function getMailings(): Collection
    {
        return $this->mailings;
    }

    public function addMailing(Mailing $mailing): self
    {
        if (!$this->mailings->contains($mailing)) {
            $this->mailings->add($mailing);
        }

        return $this;
    }

    public function removeMailing(Mailing $mailing): self
    {
        $this->mailings->removeElement($mailing);

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
            $this->user->setPartners(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPartners() !== $this) {
            $user->setPartners($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Sporthall>
     */
    public function getSporthalls(): Collection
    {
        return $this->sporthalls;
    }

    public function addSporthall(Sporthall $sporthall): self
    {
        if (!$this->sporthalls->contains($sporthall)) {
            $this->sporthalls->add($sporthall);
            $sporthall->setPartners($this);
        }

        return $this;
    }

    public function removeSporthall(Sporthall $sporthall): self
    {
        if ($this->sporthalls->removeElement($sporthall)) {
            // set the owning side to null (unless already changed)
            if ($sporthall->getPartners() === $this) {
                $sporthall->setPartners(null);
            }
        }

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    

    
    
}