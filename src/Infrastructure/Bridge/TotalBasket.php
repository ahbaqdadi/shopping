<?php

namespace App\Infrastructure\Bridge;

interface TotalBasket
{
    public function setTotal(?float $total): self;
    public function getTotal(): ?float;
}
