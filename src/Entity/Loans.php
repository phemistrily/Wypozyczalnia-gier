<?php

namespace App\Entity;

use App\Repository\LoansRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoansRepository::class)
 */
class Loans
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLoan;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateExpectedFinishLoan;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="loans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getDateLoan(): ?\DateTimeInterface
    {
        return $this->dateLoan;
    }

    public function setDateLoan(\DateTimeInterface $dateLoan): self
    {
        $this->dateLoan = $dateLoan;

        return $this;
    }

    public function getDateExpectedFinishLoan(): ?\DateTimeInterface
    {
        return $this->dateExpectedFinishLoan;
    }

    public function setDateExpectedFinishLoan(\DateTimeInterface $dateExpectedFinishLoan): self
    {
        $this->dateExpectedFinishLoan = $dateExpectedFinishLoan;

        return $this;
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

    public function __toString():string
    {
        return $this->id. ' '. $this->product;
    }
}
