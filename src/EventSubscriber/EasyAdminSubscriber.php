<?php

namespace App\EventSubscriber;

use App\Entity\Category;
use App\Entity\ProductSheet;
use App\Entity\SubCategory;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setUpdatedAt'],
            BeforeEntityDeletedEvent::class => ['delete']
        ];
    }

    public function setCreatedAt(BeforeEntityPersistedEvent $event)
    {
        $entityInstance = $event->getEntityInstance();

        $entityInstance->setCreateAt(new \DateTimeImmutable());
    }

    public function setUpdatedAt(BeforeEntityUpdatedEvent $event)
    {
        $entityInstance =$event->getEntityInstance();

        $entityInstance->setUpdateAt(new \DateTimeImmutable());
    }

    public function delete(BeforeEntityDeletedEvent $event)
    {
        $entityInstance =$event->getEntityInstance();

        if ($entityInstance instanceof Category) {
            $this->deleteCategory($entityInstance);
        } elseif ($entityInstance instanceof SubCategory) {
            $this->deleteSubCategory($entityInstance);
        } elseif ($entityInstance instanceof ProductSheet) {
            $this->deleteProductSheet($entityInstance);
        }
    }

    private function deleteCategory(Category $category) {
        foreach ($category->getSubCategories() as $subCategory) {
            $this->deleteSubCategory($subCategory);

            $category->removeSubCategory($subCategory);
        }
    }

    private function deleteSubCategory(SubCategory $subCategory) {
        foreach ($subCategory->getProductSheets() as $productSheet) {
            $this->deleteProductSheet($productSheet);

            $subCategory->removeProductSheet($productSheet);
        }
    }

    private function deleteProductSheet(ProductSheet $productSheet) {
        foreach ($productSheet->getProducts() as $product) $productSheet->removeProduct($product);
    }
}