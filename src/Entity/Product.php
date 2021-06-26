<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
#[ApiResource(
    denormalizationContext: ['groups' => ['productWrite']],
    normalizationContext: ['groups' => ['productRead']]
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="id", initialValue=11111)
     * @ORM\Column(type="integer")
     * @Groups({"productRead", "ShoppingBasketRead"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"productWrite", "productRead", "ShoppingBasketRead"})
     */
    private string $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"productWrite", "productRead", "ShoppingBasketRead"})
     */
    private string $description;

    /**
     * @ORM\OneToMany(targetEntity=ProductShoppingBasket::class, mappedBy="product")
     */
    private $productShoppingBaskets;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Groups({"productWrite", "productRead", "ShoppingBasketRead"})
     */
    private float $price;

    /**
     * @ORM\OneToMany(targetEntity=MediaObject::class, mappedBy="product")
     * @Groups({"productWrite", "productRead", "ShoppingBasketRead"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=MediaObject::class, inversedBy="products")
     * @Groups({"productWrite", "productRead", "ShoppingBasketRead"})
     */
    private $icon;

    /**
     * Product constructor.
     */
    #[Pure] public function __construct()
    {
        $this->productShoppingBaskets = new ArrayCollection();
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
     * @return Collection|ProductShoppingBasket[]
     */
    public function getProductShoppingBaskets(): Collection
    {
        return $this->productShoppingBaskets;
    }

    public function addProductShoppingBasket(ProductShoppingBasket $productShoppingBasket): self
    {
        if (!$this->productShoppingBaskets->contains($productShoppingBasket)) {
            $this->productShoppingBaskets[] = $productShoppingBasket;
            $productShoppingBasket->setProduct($this);
        }

        return $this;
    }

    public function removeProductShoppingBasket(ProductShoppingBasket $productShoppingBasket): self
    {
        if ($this->productShoppingBaskets->removeElement($productShoppingBasket)) {
            // set the owning side to null (unless already changed)
            if ($productShoppingBasket->getProduct() === $this) {
                $productShoppingBasket->setProduct(null);
            }
        }

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

    /**
     * @return Collection|MediaObject[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(MediaObject $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(MediaObject $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    public function getIcon(): ?MediaObject
    {
        return $this->icon;
    }

    public function setIcon(?MediaObject $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}
