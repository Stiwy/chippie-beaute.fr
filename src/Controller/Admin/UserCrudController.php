<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPageTitle('detail', 'Fiche %entity_label_singular%');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Numéros client')->hideOnForm(),
            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            DateField::new('date_of_birth', 'Date de naissance')->hideOnIndex(),
            TextField::new('email', 'E-mail'),
            IntegerField::new('phone', 'Téléphone'),
            ChoiceField::new('roles', 'Permission')
                ->allowMultipleChoices()
                ->autocomplete()
                ->setChoices([
                        'Client' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN',
                    ]
                ),
            TextField::new('password', 'Mot de passe')->hideOnIndex()->hideOnDetail()->setHelp('Le nouveau mot de passe ne doit pas faire plus de 25 caractères'),
            TextField::new('address', 'Adresse')->hideOnIndex(),
            TextField::new('address_complement', 'Complément d\'adresse')->hideOnIndex(),
            IntegerField::new('zip_code', 'Code postal')->hideOnIndex()->setRequired(false),
            TextField::new('city', 'Ville')->hideOnIndex(),
            CountryField::new('country', 'Pays')->hideOnIndex(),
            DateField::new('create_at', 'Créé le')->hideOnForm(),
            DateField::new('Update_at', 'Mis à jour le')->hideOnForm()
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) return;

        $entityInstance->setPassword(
            $this->userPasswordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            )
        );

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) return;

        if (strlen($entityInstance->getPassword()) <= 25) {
            $entityInstance->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPassword()
                )
            );
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::DELETE)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->reorder(Action::DETAIL, [Action::INDEX, Action::EDIT, Action::DELETE])
            ->reorder(Action::EDIT, [Action::INDEX, Action::SAVE_AND_CONTINUE, Action::SAVE_AND_RETURN, Action::DELETE])
            ;
    }
}
