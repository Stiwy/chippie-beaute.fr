<?php

namespace App\Controller\Admin;

use App\Entity\ProductSheet;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

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


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Identifiant')->hideOnForm(),
            TextField::new('title', 'Titre'),
            SlugField::new('slug', 'Liens')->setTargetFieldName('title')->hideOnIndex(),
            BooleanField::new('activ', 'Activé'),
            BooleanField::new('featured', 'Mettre en avant'),
            AssociationField::new('subCategory', 'Sous catégorie'),
            TextEditorField::new('description', 'Déscription')->hideOnIndex(),
            TextField::new('brand', 'Marque'),
            AssociationField::new('products', 'Références associées'),
            DateField::new('createAt', 'Créé le')->hideOnForm(),
            DateField::new('updateAt', 'Mis à jour le')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new('Dupliquer')->linkToCrudAction('duplicate')->setCssClass('btn btn-info');

        return $actions
            ->add(Crud::PAGE_EDIT, Action::DELETE)
            ->add(Crud::PAGE_INDEX, $duplicate)
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->add(Crud::PAGE_DETAIL, $duplicate)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->reorder(Action::DETAIL, [Action::INDEX, 'Dupliquer', Action::EDIT, Action::DELETE])
            ->reorder(Action::EDIT, [Action::INDEX, 'Dupliquer', Action::SAVE_AND_CONTINUE, Action::SAVE_AND_RETURN, Action::DELETE])
            ;
    }

    public function duplicate(AdminContext $context, EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator): Response
    {
        $productSheet = $context->getEntity()->getInstance();

        $duplicateProductSheet = clone $productSheet;

        parent::persistEntity($entityManager, $duplicateProductSheet);

        $url = $adminUrlGenerator->setController(self::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($duplicateProductSheet->getId())
            ->generateUrl();

        return $this->redirect($url);
    }
}
