<?php 

namespace Omar\Scandiweb;

class Furniture extends Product
{
    private $dimensions;

    public function __construct(string $sku, string $name, float $price, array $dimensions)
    {
        parent::__construct($sku, $name, $price);
        $this->dimensions = $dimensions;
    }

    public function getType(): string
    {
        return 'furniture';
    }

    public function getAdditional(): array
    {
        return ['dimensions' => $this->dimensions];
    }

    public function getDimensions(): array
    {
        return $this->dimensions;
    }
}
?>