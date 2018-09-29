<?php

namespace TalkingBit\BddExample\Persistence;

use TalkingBit\BddExample\Product;
use TalkingBit\BddExample\ProductRepository;

class InMemoryProductRepository implements ProductRepository
{
    public function getById(string $productId): Product
    {
        return new Product(101, 'Product 1', 10);
    }

    public function store(Product $product): void
    {
        // TODO: Implement store() method.
    }
}
