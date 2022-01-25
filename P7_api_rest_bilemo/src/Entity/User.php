<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;


/**
 * @ApiResource(
 * denormalizationContext={"groups":{"users:write"}},
 * normalizationContext={"groups":{"users:read"}},
 * collectionOperations={
 *         "get",
 *         "post"={"security"="is_granted('ROLE_ADMIN')"},
 *     },
 * itemOperations={
 *         "get"={"security"="is_granted('get',object)","security_message"="You can only acess the details of your users. Please try again"},
 *         "put"={"security"="is_granted('edit', object)","security_message"="You can only acess the details of your users. Please try again"},
 *         "patch"={"security"="is_granted('edit', object)","security_message"="You can only acess  the details of your users. Please try again"},
 *         "delete"={"security"="is_granted('delete', object)","security_message"="You can only acess  the details of your users. Please try again"},
 *     },
 *  )
 * @UniqueEntity("email",message="This email/username is already in the system.","username",message="This email/username is already in the system.")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct()
    {
        $this->createDate = new DateTime();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users:read"})
     */
    
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"users:write","users:read"})
     * @Assert\NotBlank
     */
    private $username=null;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password=null;

    /**
     * @ORM\Column(type="string", length=255) 
     * @Groups({"users:write","users:read"})
     */
    private $firstName=null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"users:write","users:read"})
     */
    private $lastName=null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     * message = "The email '{{ value }}' is not a valid email."
     * )
     * @Groups({"users:write","users:read"})
     */
    private $email=null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex("/^\d+$/",message="number only")
     * @Groups({"users:write","users:read"})
     */
    private $phoneNo=null;

    /**
     * @Groups({"users:write"})
     * @SerializedName("password")
     * @Assert\NotBlank
    * @Assert\Length(
    *      min = 8,
    *      max = 20,
    *      minMessage = "Please enter at least {{ limit }} characters.",
    *      maxMessage = "Please enter no longer than {{ limit }} characters"
    * )
     */
    private $plainPassword=null;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="users",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"users:read"})
     */
    private $client=null;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * 
     */
    private $createDate=null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getPhoneNo(): ?string
    {
        return $this->phoneNo;
    }

    public function setPhoneNo(string $phoneNo): self
    {
        $this->phoneNo = $phoneNo;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
    public function hasRoles(string $roles): bool
    {
        return in_array($roles, $this->roles);
    }

}
