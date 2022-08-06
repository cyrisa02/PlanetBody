<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 190)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isEnable = null;

    #[ORM\ManyToMany(targetEntity: Partner::class, mappedBy: 'permissions')]
    private Collection $partners;

    #[ORM\ManyToMany(targetEntity: Sporthall::class, mappedBy: 'permissions')]
    private Collection $sporthalls;

    public function __construct()
    {
        $this->partners = new ArrayCollection();
        $this->sporthalls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $partner->addPermission($this);
        }

        return $this;
    }

    public function removePartner(Partner $partner): self
    {
        if ($this->partners->removeElement($partner)) {
            $partner->removePermission($this);
        }

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
            $sporthall->addPermission($this);
        }

        return $this;
    }

    public function removeSporthall(Sporthall $sporthall): self
    {
        if ($this->sporthalls->removeElement($sporthall)) {
            $sporthall->removePermission($this);
        }

        return $this;
    }
}
