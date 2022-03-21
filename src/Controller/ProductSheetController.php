<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductSheetController extends AbstractController
{
    #[Route('/product/sheet', name: 'app_product_sheet')]
    public function index(): Response
    {
        return $this->render('product_sheet/index.html.twig', [
            'controller_name' => 'ProductSheetController',
        ]);
    }
}
