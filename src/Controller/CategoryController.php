<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\Price;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/{category}', name: 'app_category')]
    public function show($category, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['label' => $category, 'active' => true]);
        $productSheetList = [];

        $title = $category->getLabel();
        $breadcrumb = '<span class="text-sm block -mt-10"><a href="' . $this->generateUrl('app_home') . '">Chippie Beaute</a> / <b>' . $category->getLabel() . '</b></span>';


        foreach ($category->getSubCategories() as $subCategory) {
            if ($subCategory->getActive()) {
                foreach ($subCategory->getProductSheets() as $productSheet) {
                    foreach ($productSheet->getProducts() as $product) {
                        if ($product->getPrincipal()) {
                            if ($productSheet->getActiv() && $product->getActiv()) {
                                $productSheetList[] = [
                                    'title' => $productSheet->getTitle(),
                                    'title_reference' => $product->getTitle(),
                                    'brand' => $productSheet->getBrand(),
                                    'image_1' => $product->getImage1(),
                                    'prix_ttc' => Price::priceTTC($product->getPrice(), $product->getTva()),
                                ];
                            }
                        }
                    }
                }
            }
        }
        return $this->render('product_sheet/index.html.twig', compact('productSheetList', 'category', 'breadcrumb', 'title'));
    }
}
