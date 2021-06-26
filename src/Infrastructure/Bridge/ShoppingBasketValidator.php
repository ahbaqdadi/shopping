<?php


namespace App\Infrastructure\Bridge;


use Doctrine\Common\Collections\Collection;

interface ShoppingBasketValidator
{
    public function getProducts(): Collection;
}
