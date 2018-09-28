<?php

namespace TalkingBit\BddExample;

interface ProductRepository
{
    public function getById(string $productId): Product;

    public function store(Product $product): void;
}
