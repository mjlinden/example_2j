<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{name}/{price}', name: 'create_product')]
    public function createProduct(ManagerRegistry $doctrine, string $name, int $price): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    #[Route('/show/products', name: 'show_products')]
    public function showProducts(ManagerRegistry $doctrine): Response {
        $products=$doctrine->getRepository(Product::class)->findAll();
        //dd($products);
        return $this->render('bezoeker/show_products.html.twig',['products'=>$products,]);
    }

    #[Route('/product', name: 'product')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $category = new Category();
        $category->setName('Computer Peripherals');

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19);

        // relates this product to the category
        $product->setCategory($category);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($category);
        $entityManager->persist($product);
        $entityManager->flush();

        return new Response(
            'Saved new product with id: '.$product->getId()
            .' and new category with id: '.$category->getId()
        );
    }
}