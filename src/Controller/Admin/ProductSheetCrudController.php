<?php

namespace App\Controller\Admin;

use App\Entity\ProductSheet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductSheetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductSheet::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Fiche produit')
            ->setEntityLabelInPlural('Fiches produits')
            ;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
