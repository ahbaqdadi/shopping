<?php


namespace App\Service;


use ApiPlatform\Core\Exception\FilterValidationException;
use App\Entity\ShoppingBasket;

class ShoppingBasketHandler
{
    public function checkUniqueProducts(ShoppingBasket $shoppingBasket)
    {
        foreach ($shoppingBasket->getProducts() as $product) {
            $counter = 0;

            foreach ($shoppingBasket->getProducts() as $subProduct) {

                if($subProduct->getProduct()->getId() == $product->getProduct()->getId()) {
                    $counter ++;
                }
            }

            if ($counter > 1) {
                throw  new FilterValidationException(["products"], "products must be unique");
            }
        }

    }
}
