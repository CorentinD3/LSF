<?php

namespace App\Controller\Admin;

use App\Entity\Provenance;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProvenanceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Provenance::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('departement')
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->setPermission(Action::NEW, 'ROLE_ADMIN')
        ->setPermission(Action::EDIT, 'ROLE_ADMIN')
        ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ->setPermission(Action::BATCH_DELETE, 'ROLE_ADMIN')

    ;} 
     
        
   

    

}
