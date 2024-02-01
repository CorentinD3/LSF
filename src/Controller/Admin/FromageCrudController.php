<?php

namespace App\Controller\Admin;

use App\Entity\Fromage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FromageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fromage::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextareaField::new('description')-> setMaxLength(28)  ,
            BooleanField::new('display')->hideWhenCreating(),
            AssociationField::new('Animal'),
            IntegerField::new('matieregrasse')->setLabel("Matière grasse"),
            AssociationField::new('label'),
            AssociationField::new('lait'),
            AssociationField::new('Pate'),
            AssociationField::new('Provenance'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex()->setLabel("Image"),
            ImageField::new('image')->setBasePath('/uploads/fromages/')->onlyOnIndex(),


        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            ->setPageTitle(Crud::PAGE_INDEX, 'Fromages')

            ;
    }

}
