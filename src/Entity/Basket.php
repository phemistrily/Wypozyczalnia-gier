<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BasketRepository::class)
 */
class Basket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="baskets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=BasketLanes::class, mappedBy="basket")
     */
    private $basketLanes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;


    public function __construct(User $user, string $status = "NEW")
    {
        $this->user = $user;
        $this->status = $status;
        $this->product = new ArrayCollection();
        $this->basketLanes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $basketLane->setBasket($this);
        }

        return $this;
    }

    public function removeBasketLane(BasketLanes $basketLane): self
    {
        if ($this->basketLanes->removeElement($basketLane)) {
            // set the owning side to null (unless already changed)
            if ($basketLane->getBasket() === $this) {
                $basketLane->setBasket(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
