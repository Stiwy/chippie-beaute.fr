<?php

namespace App\Controller;

use App\Repository\SubCategoryRepository;
use App\Service\Price;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubCategoryController extends AbstractController
{
    #[Route('nos-produits/{category}/{subCategory}', name: 'app_sub_category')]
    public function show($subCategory, SubCategoryRepository $subCategoryRepository): Response
    {
        $subCategory = $subCategoryRepository->findOneBy(['slug' => $subCategory, 'active' => true]);
        $category = $subCategory->getCategorie();

        $productSheetList = [];

        $title = $subCategory->getLabel();
        $breadcrumb = '<span class="text-sm block -mt-10"><a href="' . $this->generateUrl('app_home') . '">Chippie Beaute</a> / <a href="' . $this->generateUrl('app_category', ['category' => $category->getSlug()]) . '">'. $category->getLabel() .'</a>  / <b>' . $subCategory->getLabel() . '</b></span>';

        foreach ($subCategory->getProductSheets() as $productSheet) {
            foreach ($productSheet->getProducts() as $product) {
                if ($product->getPrincipal()) {
                    if ($productSheet->getActiv() && $product->getActiv()) {
                        $productSheetList[] = [
                            'title' => $productSheet->getTitle(),
                            'title_reference' => $product->getTitle(),
                            'brand' => $productSheet->getBrand(),
                            'image_1' => $product->getImage1(),
                            'slug' => $productSheet->getSlug(),
                            'reference' => $product->getReference(),
                            'sub_category' => $productSheet->getSubCategory(),
                            'prix_ttc' => Price::priceTTC($product->getPrice(), $product->getTva()),
                        ];
                    }
                }
            }
        }

        return $this->render('product_sheet/index.html.twig', compact('productSheetList', 'subCategory', 'category', 'breadcrumb', 'title'));
    }
}
