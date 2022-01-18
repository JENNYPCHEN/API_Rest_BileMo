<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * collectionOperations={"GET"},
 * itemOperations={"GET"},
 * normalizationContext={"groups":{"products:read"}}
 * 
 * 
 *)
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    public function __construct(){
        $this->createDate=new DateTime();
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
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"products:read"})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=500)
     * @Groups({"products:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"products:read"})
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     * @Groups({"products:read"})
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="date")
     */
    private $createDate;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"products:read"})
     */
    private $Brand;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $size;

    /**
     * @ORM\Column(type="float")
     */
    private $storage;
    
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

    public function setCreateDate(\DateTimeInterface $createDate): self
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

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
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
