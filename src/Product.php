<?php

namespace Omar\Scandiweb;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;

    public function __construct(string $sku, string $name, float $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    abstract public function getType(): string;
    abstract public function getAdditional(): array;
}

?>
