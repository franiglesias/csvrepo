<?php

namespace TalkingBit\BddExample;

class Product
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var float */
    private $price;

    public function __construct(int $id, string $name, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function setPrice(float $price): void
    {
    }

    public function price(): float
    {
        return $this->price;
    }

    public function id(): int
    {
        return $this->id;
    }
}
