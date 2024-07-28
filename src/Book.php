<?php 

namespace Omar\Scandiweb;

class Book extends Product
{
    private float $weight;

    public function __construct(string $sku, string $name, float $price, float $weight)
    {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function getType(): string
    {
        return 'book';
    }

    public function getAdditional(): array
    {
        return ['weight' => $this->weight];
    }

    public function getWeight(): float
    {
        return $this->weight;
    }
}