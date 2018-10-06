<?php

namespace Spec\TalkingBit\BddExample;

use TalkingBit\BddExample\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(101, 'Product 1', 10.25);
        $this->shouldHaveType(Product::class);
    }
}
