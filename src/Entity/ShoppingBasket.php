<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Infrastructure\Bridge\ShoppingBasketValidator;
use App\Infrastructure\Bridge\TotalBasket;
use App\Repository\ShoppingBasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ShoppingBasketRepository::class)
 */
#[ApiResource(
    denormalizationContext: ['groups' => ['ShoppingBasketWrite']],
    normalizationContext: ['groups' => ['ShoppingBasketRead']]
)]
class ShoppingBasket implements TotalBasket, ShoppingBasketValidator
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ShoppingBasketRead"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ProductShoppingBasket::class, mappedBy="shoppingBasket", cascade={"persist"})
     * @Groups({"ShoppingBasketRead", "ShoppingBasketWrite", "ShoppingBasketPut"})
     * @Assert\Unique()
     */
    private $products;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"ShoppingBasketRead", "ShoppingBasketPut"})
     */
    private $total;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ProductShoppingBasket[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductShoppingBasket $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setShoppingBasket($this);
        }

        return $this;
    }

    public function removeProduct(ProductShoppingBasket $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getShoppingBasket() === $this) {
                $product->setShoppingBasket(null);
            }
        }

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
