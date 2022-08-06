<?php

namespace App\Entity;

use App\Repository\MailingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailingRepository::class)]
class Mailing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 190)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'mailings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $categories = null;

    #[ORM\ManyToMany(targetEntity: Sporthall::class, mappedBy: 'mailings')]
    private Collection $sporthalls;

    #[ORM\ManyToMany(targetEntity: Partner::class, mappedBy: 'mailings')]
    private Collection $partners;

    public function __construct()
    {
        $this->sporthalls = new ArrayCollection();
        $this->partners = new ArrayCollection();
    }

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCategories(): ?Category
    {
        return $this->categories;
    }

    public function setCategories(?Category $categories): self
    {
        $this->categories = $categories;

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
            $sporthall->addMailing($this);
        }

        return $this;
    }

    public function removeSporthall(Sporthall $sporthall): self
    {
        if ($this->sporthalls->removeElement($sporthall)) {
            $sporthall->removeMailing($this);
        }

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
            $partner->addMailing($this);
        }

        return $this;
    }

    public function removePartner(Partner $partner): self
    {
        if ($this->partners->removeElement($partner)) {
            $partner->removeMailing($this);
        }

        return $this;
    }
}
