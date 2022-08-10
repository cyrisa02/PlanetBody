<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 190)]
    private ?string $name = null;

    #[ORM\Column(length: 190)]
    private ?string $address = null;

    #[ORM\Column(length: 190)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 190)]
    private ?string $city = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Maincustomer $maincustomer = null;

   

    
    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Sentmail::class)]
    private Collection $sentmails;

    #[ORM\Column(length: 190, nullable: true)]
    private ?string $contact = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Partner $partners = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Sporthall $sporthalls = null;

    
    /**
 	*This constructor is for the date
 	*/
 	public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->sentmails = new ArrayCollection();
       
        
    }

    public function __toString()
     {
       return $this->email;
     }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getMaincustomer(): ?Maincustomer
    {
        return $this->maincustomer;
    }

    public function setMaincustomer(?Maincustomer $maincustomer): self
    {
        $this->maincustomer = $maincustomer;

        return $this;
    }

    

    

    /**
     * @return Collection<int, Sentmail>
     */
    public function getSentmails(): Collection
    {
        return $this->sentmails;
    }

    public function addSentmail(Sentmail $sentmail): self
    {
        if (!$this->sentmails->contains($sentmail)) {
            $this->sentmails->add($sentmail);
            $sentmail->setUsers($this);
        }

        return $this;
    }

    public function removeSentmail(Sentmail $sentmail): self
    {
        if ($this->sentmails->removeElement($sentmail)) {
            // set the owning side to null (unless already changed)
            if ($sentmail->getUsers() === $this) {
                $sentmail->setUsers(null);
            }
        }

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

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

    public function getSporthalls(): ?Sporthall
    {
        return $this->sporthalls;
    }

    public function setSporthalls(?Sporthall $sporthalls): self
    {
        $this->sporthalls = $sporthalls;

        return $this;
    }

    
}