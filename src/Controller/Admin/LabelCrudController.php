<?php

namespace App\Controller\Admin;

use App\Entity\Label;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LabelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Label::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            ->setPageTitle(Crud::PAGE_INDEX, 'Labels')

            ;
    }

    public function configureActions(Actions $actions): Actions
    {
       
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ADMIN')

        ;
    }

}
