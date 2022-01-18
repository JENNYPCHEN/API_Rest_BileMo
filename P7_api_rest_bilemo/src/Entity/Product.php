<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 * collectionOperations={"GET"={"normalization_Context"={"groups":{"products:read"}}}},
 * itemOperations={"GET"={"normalization_Context"={"groups":{"products:read"}}}},
 * normalizationContext={"groups":{"products:read"}},
 *)
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ApiFilter(RangeFilter::class,properties={"price"})
 * @ApiFilter(SearchFilter::class, properties={"name"="partial","description"="partial"})
 */
class Product
{
    public function __construct()
    {
        $this->createDate = new DateTimeImmutable();
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"products:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"products:read"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min="10",
     *      max="50",
     *      minMessage="Product name should contain between 10 to 50 characters",
     *      maxMessage="Product name should contain between 10 to 50 characters"
     * )
     */
    private $name=null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"products:read"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min="5",
     *      max="20",
     *      minMessage="Product name should contain between 5 to 20 characters",
     *      maxMessage="Product name should contain between 5 to 20 characters"
     * )
     */
    private $model=null;

    /**
     * @ORM\Column(type="string", length=500)
     * @Groups({"products:read"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min="50",
     *      max="500",
     *      minMessage="Product name should contain between 50 to 500 characters",
     *      maxMessage="Product name should contain between 50 to 500 characters"
     * )
     */
    
    private $description=null;

    /**
     * @ORM\Column(type="float")
     * @Groups({"products:read"})
     * @SerializedName("price(€)")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $price=null;
    /**
     * @ORM\Column(type="date")
     * @Groups({"products:read"})
     * @Assert\NotBlank
     * @Assert\Date
     * 
     */
    private $releaseDate=null;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Date
     */
    private $createDate=null;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"products:read"})
     */
    private $Brand=null;

    /**
     * @ORM\Column(type="float")
     * @Groups({"products:read"})
     * @SerializedName("weight(g)")
     * @Assert\NotBlank
     * @Assert\Positive
     * 
     */
    private $weight=null;

    /**
     * @ORM\Column(type="float")
     * @SerializedName("screen size(inch)")
     * @Groups({"products:read"})
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $size=null;

    /**
     * @ORM\Column(type="float")
     * @Groups({"products:read"})
     * @SerializedName("Storage(GB)")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $storage=null;

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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeImmutable $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->Brand;
    }

    public function setBrand(?Brand $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(float $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getStorage(): ?float
    {
        return $this->storage;
    }

    public function setStorage(float $storage): self
    {
        $this->storage = $storage;

        return $this;
    }
}
