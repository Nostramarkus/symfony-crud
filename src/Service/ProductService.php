<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ProductRepository $productRepository
    ) {}

    // Nieuw product aanmaken
    public function createProduct(
        string $name,
        int $priceInCents,
        int $stock
    ): Product {
        $product = new Product();

        $product->setName($name);
        $product->setPriceInCents($priceInCents);
        $product->setStock($stock);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    // Product ophalen op basis van ID
    public function getProduct(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    // Bestaand product bijwerken
    public function updateProduct(
        int $id,
        string $name,
        int $priceInCents,
        int $stock
    ): ?Product {
        $product = $this->getProduct($id);

        if (!$product) {
            return null;
        }

        $product->setName($name);
        $product->setPriceInCents($priceInCents);
        $product->setStock($stock);

        $this->entityManager->flush();

        return $product;
    }

    // Product verwijderen
    public function deleteProduct(int $id): bool
    {
        $product = $this->getProduct($id);

        if (!$product) {
            return false;
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return true;
    }
}
