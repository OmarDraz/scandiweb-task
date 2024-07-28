<?php

namespace Omar\Scandiweb;

use Omar\Scandiweb\Book;
use Omar\Scandiweb\Furniture;
use Omar\Scandiweb\Dvd;
use Omar\Scandiweb\Product;

class ProductFactory
{
    private static $typeToClassMap = [
        'book' => Book::class,
        'furniture' => Furniture::class,
        'dvd' => Dvd::class,
    ];

    public static function createProduct(array $data): Product
    {
        if (!isset(self::$typeToClassMap[$data['type']])) {
            throw new \Exception('Invalid product type');
        }

        $class = self::$typeToClassMap[$data['type']];
        return self::instantiateProduct($class, $data);
    }

    private static function instantiateProduct(string $class, array $data): Product
    {
        // Use reflection to call the appropriate constructor
        $reflection = new \ReflectionClass($class);
        return $reflection->newInstanceArgs([
            $data['sku'],
            $data['name'],
            $data['price'],
            $data['additional']
        ]);
    }
}
?>
