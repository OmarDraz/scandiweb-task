<?php

namespace Omar\Scandiweb;

use PDO;

class ProductRepository
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Product $product)
    {
        if ($this->skuExists($product->getSku())) {
            throw new \Exception('SKU already exists. Please use a different SKU.');
        }

        $query = 'INSERT INTO products (sku, name, price, type, additional) VALUES (:sku, :name, :price, :type, :additional)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $product->getSku());
        $stmt->bindParam(':name', $product->getName());
        $stmt->bindParam(':price', $product->getPrice());
        $stmt->bindParam(':type', $product->getType());
        $stmt->bindParam(':additional', json_encode($product->getAdditional()));
        $stmt->execute();
    }

    private function skuExists($sku)
    {
        $query = 'SELECT COUNT(*) FROM products WHERE sku = :sku';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function getAll()
    {
        $query = 'SELECT * FROM products';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as &$product) {
            $product['additional'] = json_decode($product['additional'], true);
        }

        return $products;
    }

    public function get($id)
    {
        $query = 'SELECT * FROM products WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $product['additional'] = json_decode($product['additional'], true);
        }

        return $product;
    }

    public function update($id, Product $product)
    {
        $query = 'UPDATE products SET sku = :sku, name = :name, price = :price, type = :type, additional = :additional WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':sku', $product->getSku());
        $stmt->bindParam(':name', $product->getName());
        $stmt->bindParam(':price', $product->getPrice());
        $stmt->bindParam(':type', $product->getType());
        $stmt->bindParam(':additional', json_encode($product->getAdditional()));
        $stmt->execute();
    }

    public function delete($id)
    {
        $query = 'DELETE FROM products WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteMultiple(array $ids)
    {
        $placeholders = rtrim(str_repeat('?, ', count($ids)), ', ');
        $query = "DELETE FROM products WHERE id IN ($placeholders)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($ids);
    }
}
?>
