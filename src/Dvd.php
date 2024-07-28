<?php

namespace Omar\Scandiweb;


class Dvd extends Product
{
    private $size;

    public function __construct(string $sku, string $name, float $price, float $size)
    {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function getType(): string
    {
        return 'dvd';
    }

    public function getAdditional(): array
    {
        return ['size' => $this->size];
    }

    public function getSize(): float
    {
        return $this->size;
    }
}

?>