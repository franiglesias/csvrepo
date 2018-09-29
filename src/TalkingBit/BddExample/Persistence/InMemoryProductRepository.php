<?php

namespace TalkingBit\BddExample\Persistence;

use TalkingBit\BddExample\Product;
use TalkingBit\BddExample\ProductRepository;

class InMemoryProductRepository implements ProductRepository
{
    private $products;

    public function getById(string $productId): Product
    {
        return $this->products[$productId];
    }

    public function store(Product $product): void
    {
        $this->products[$product->id()] = $product;
    }
}
