<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;
use App\Dto\ProductInput;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    // Alle producten ophalen
    #[Route('/api/products', methods: ['GET'])]
    public function index(
        ProductRepository $productRepository
    ): JsonResponse {
        $products = $productRepository->findAll();

        return $this->json($products);
    }

    // Specifiek product ophalen
    #[Route('/api/products/{id}', methods: ['GET'])]
    public function show(
        int $id,
        ProductService $productService
    ): JsonResponse {
        $product = $productService->getProduct($id);

        if (!$product) {
            return $this->json(
                ['error' => 'Product niet gevonden.'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'priceInCents' => $product->getPriceInCents(),
            'stock' => $product->getStock()
        ]);
    }

    // Nieuw product aanmaken
    #[Route('/api/products', methods: ['POST'])]
    public function create(
        Request $request,
        ProductService $productService,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = $request->toArray();

        $input = new ProductInput();
        $input->name = $data['name'] ?? null;
        $input->priceInCents = $data['priceInCents'] ?? null;
        $input->stock = $data['stock'] ?? null;

        $errors = $validator->validate($input);

        if (count($errors) > 0) {
            $messages = [];

            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json(
                ['errors' => $messages],
                Response::HTTP_BAD_REQUEST
            );
        }

        $product = $productService->createProduct(
            $input->name,
            $input->priceInCents,
            $input->stock
        );

        return $this->json([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'priceInCents' => $product->getPriceInCents(),
            'stock' => $product->getStock()
        ], Response::HTTP_CREATED);
    }

    // Bestaand product bijwerken
    #[Route('/api/products/{id}', methods: ['PUT'])]
    public function update(
        int $id,
        Request $request,
        ProductService $productService,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = $request->toArray();

        $input = new ProductInput();
        $input->name = $data['name'] ?? null;
        $input->priceInCents = $data['priceInCents'] ?? null;
        $input->stock = $data['stock'] ?? null;

        $errors = $validator->validate($input);

        if (count($errors) > 0) {
            $messages = [];

            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json(
                ['errors' => $messages],
                Response::HTTP_BAD_REQUEST
            );
        }

        $product = $productService->updateProduct(
            $id,
            $input->name,
            $input->priceInCents,
            $input->stock
        );

        if (!$product) {
            return $this->json(
                ['error' => 'Product niet gevonden.'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'priceInCents' => $product->getPriceInCents(),
            'stock' => $product->getStock()
        ]);
    }

    // Product verwijderen
    #[Route('/api/products/{id}', methods: ['DELETE'])]
    public function delete(
        int $id,
        ProductService $productService
    ): JsonResponse {
        $deleted = $productService->deleteProduct($id);

        if (!$deleted) {
            return $this->json(
                ['error' => 'Product niet gevonden.'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
