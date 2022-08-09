<?php

namespace App\Entity;

use App\Repository\SporthallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SporthallRepository::class)]
class Sporthall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;    

    #[ORM\Column]
    private ?bool $isEnable = null;

    public function __toString()
     {
       return $this->isEnable;
     }


    

    #[ORM\OneToMany(mappedBy: 'sporthalls', targetEntity: Partner::class)]
    private Collection $partners;

    #[ORM\ManyToMany(targetEntity: Permission::class, inversedBy: 'sporthalls')]
    private Collection $permissions;

    #[ORM\ManyToMany(targetEntity: Mailing::class, inversedBy: 'sporthalls')]
    private Collection $mailings;

    #[ORM\OneToOne(mappedBy: 'sporthalls', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        
        $this->partners = new ArrayCollection();
        $this->permissions = new ArrayCollection();
        $this->mailings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    

    

    
    /**
     * @return Collection<int, Partner>
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    public function addPartner(Partner $partner): self
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
            $partner->setSporthalls($this);
        }

        return $this;
    }

    public function removePartner(Partner $partner): self
    {
        if ($this->partners->removeElement($partner)) {
            // set the owning side to null (unless already changed)
            if ($partner->getSporthalls() === $this) {
                $partner->setSporthalls(null);
            }
        }

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
            $this->user->setSporthalls(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getSporthalls() !== $this) {
            $user->setSporthalls($this);
        }

        $this->user = $user;

        return $this;
    }
}