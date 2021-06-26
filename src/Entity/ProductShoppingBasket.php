<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductShoppingBasketRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductShoppingBasketRepository::class)
 */
#[ApiResource]
class ProductShoppingBasket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productShoppingBaskets")
     * @Groups({"ShoppingBasketRead", "ShoppingBasketWrite"})
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"ShoppingBasketRead", "ShoppingBasketWrite"})
     * @Assert\Positive()
     */
    private $quantity = 1;

    /**
     * @ORM\ManyToOne(targetEntity=ShoppingBasket::class, inversedBy="products")
     */
    private $shoppingBasket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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

    public function getShoppingBasket(): ?ShoppingBasket
    {
        return $this->shoppingBasket;
    }

    public function setShoppingBasket(?ShoppingBasket $shoppingBasket): self
    {
        $this->shoppingBasket = $shoppingBasket;

        return $this;
    }
}
