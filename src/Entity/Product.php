<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=ProductCategory::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productCategory;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=BasketLanes::class, mappedBy="product")
     */
    private $basketLanes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $platform;

    public function __construct(string $name, string $description ,float $price,int $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->baskets = new ArrayCollection();
        $this->basketLanes = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProductCategory(): ?ProductCategory
    {
        return $this->productCategory;
    }

    public function setProductCategory(?ProductCategory $productCategory): self
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|BasketLanes[]
     */
    public function getBasketLanes(): Collection
    {
        return $this->basketLanes;
    }

    public function addBasketLane(BasketLanes $basketLane): self
    {
        if (!$this->basketLanes->contains($basketLane)) {
            $this->basketLanes[] = $basketLane;
            $basketLane->setProduct($this);
        }

        return $this;
    }

    public function removeBasketLane(BasketLanes $basketLane): self
    {
        if ($this->basketLanes->removeElement($basketLane)) {
            // set the owning side to null (unless already changed)
            if ($basketLane->getProduct() === $this) {
                $basketLane->setProduct(null);
            }
        }

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(?string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function __toString():string
    {
        return $this->name;
    }
}
