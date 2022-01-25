<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ApiResource( 
 * collectionOperations={},
 * itemOperations={"get"={"normalization_context"={"groups":{"clients:read"}},"security"="is_granted('ROLE_ADMIN') and object===user","security_message"="You can only read your detail. Please try again"}},
 * )
 * normalizationContext={"groups":{"users:read"}},
 * @UniqueEntity("email",message="This email is in our database")
 */
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct()
    {
        $this->createDate = new DateTime();
        $this->roles=["ROLE_ADMIN"];
        $this->user = new ArrayCollection();
        $this->users = new ArrayCollection();

    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clients:read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Groups({"users:read","clients:read"})
     * @Assert\Email(
     * message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email=null;

    /**
     * @ORM\Column(type="json")
     * 
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password=null;

    /**
     * @ORM\Column(type="string")
     * @Groups({"clients:read"})
     * @Assert\NotBlank
     *  @Assert\Length(
     *      min = 14,
     *      max = 18,
     *      minMessage = "Please enter {{ limit }} characters siret number",
     *      maxMessage = "Please enter {{ limit }} characters siret number"
     * )
     * @Assert\Regex("/^\d+$/",message="number only")
     * 
     */
    private $siret=null;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"clients:read"})
     * @Assert\Regex("/^\d+$/",message="number only")
     */
    private $phoneNo=null;

    /**
     * @ORM\Column(type="date")
     * @Groups({"clients:read"})
     * @Assert\NotBlank
     */
    private $createDate=null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"users:read","clients:read"})
     */
    private $company=null;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="client", orphanRemoval=true)
     */
    private $users;

    /**
     * @Assert\Length(
     *      min = 8,
     *      max = 20,
     *      minMessage = "Please enter at least {{ limit }} characters.",
     *      maxMessage = "Please enter no longer than {{ limit }} characters"
     * )
     * @SerializedName("password")
     */
    private $plainPassword;


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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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
        $roles[] = 'ROLE_ADMIN';

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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
      $this->plainPassword = null;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getPhoneNo(): ?string
    {
        return $this->phoneNo;
    }

    public function setPhoneNo(string $phoneNo): self
    {
        $this->phoneNo = $phoneNo;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClient($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getClient() === $this) {
                $user->setClient(null);
            }
        }

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function hasRoles(string $roles): bool
    {
        return in_array($roles, $this->roles);
    }




}
