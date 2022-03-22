<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\ProductSheetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductSheetController extends AbstractController
{
    #[Route('/nos-produits/{category}/{subCategory}/{productSheet}/{product}', name: 'app_product_sheet')]
    public function show($product, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['reference' => $product]);

        $images = [
            $product->getImage1(),
            $product->getImage2(),
            $product->getImage3(),
            $product->getImage4(),
        ];

        return $this->render('product_sheet/show.html.twig', compact('product', 'images'));
    }
}
