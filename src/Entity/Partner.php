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
    private ?string $contact = null;

    #[ORM\Column(length: 190)]
    private ?string $contract = null;

    #[ORM\Column]
    private ?bool $is_enable = null;

    #[ORM\OneToMany(mappedBy: 'partners', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'partners', targetEntity: Maincustomer::class)]
    private Collection $maincustomers;

    #[ORM\ManyToOne(inversedBy: 'partners')]
    private ?Sporthall $sporthalls = null;

    #[ORM\ManyToMany(targetEntity: Permission::class, inversedBy: 'partners')]
    private Collection $permissions;

    #[ORM\ManyToMany(targetEntity: Mailing::class, inversedBy: 'partners')]
    private Collection $mailings;

    
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->maincustomers = new ArrayCollection();
        $this->permissions = new ArrayCollection();
        $this->mailings = new ArrayCollection();
    }

    

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

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->is_enable;
    }

    public function setIsEnable(bool $is_enable): self
    {
        $this->is_enable = $is_enable;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setPartners($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPartners() === $this) {
                $user->setPartners(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Maincustomer>
     */
    public function getMaincustomers(): Collection
    {
        return $this->maincustomers;
    }

    public function addMaincustomer(Maincustomer $maincustomer): self
    {
        if (!$this->maincustomers->contains($maincustomer)) {
            $this->maincustomers->add($maincustomer);
            $maincustomer->setPartners($this);
        }

        return $this;
    }

    public function removeMaincustomer(Maincustomer $maincustomer): self
    {
        if ($this->maincustomers->removeElement($maincustomer)) {
            // set the owning side to null (unless already changed)
            if ($maincustomer->getPartners() === $this) {
                $maincustomer->setPartners(null);
            }
        }

        return $this;
    }

    public function getSporthalls(): ?Sporthall
    {
        return $this->sporthalls;
    }

    public function setSporthalls(?Sporthall $sporthalls): self
    {
        $this->sporthalls = $sporthalls;

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

    
    
}