<?php

namespace spec\TalkingBit\BddExample\Persistence;

use TalkingBit\BddExample\Persistence\InMemoryProductRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TalkingBit\BddExample\ProductRepository;

class InMemoryProductRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProductRepository::class);
    }
}
