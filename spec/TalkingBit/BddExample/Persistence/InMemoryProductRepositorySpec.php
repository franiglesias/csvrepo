<?php

namespace spec\TalkingBit\BddExample\Persistence;

use PhpSpec\ObjectBehavior;
use TalkingBit\BddExample\Product;
use TalkingBit\BddExample\ProductRepository;

class InMemoryProductRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProductRepository::class);
    }

    public function it_should_store_products(Product $product)
    {
        $product->id()->willReturn(1);
        $this->store($product);
        $this->getById(1)->shouldBe($product);
    }

    public function it_should_retrieve_a_product_specified_by_its_id(Product $product1, Product $product2)
    {
        $product1->id()->willReturn(1);
        $product2->id()->willReturn(2);

        $this->store($product1);
        $this->store($product2);

        $this->getById(1)->shouldBe($product1);
        $this->getById(2)->shouldBe($product2);
    }
}
