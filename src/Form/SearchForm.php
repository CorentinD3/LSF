<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Animal;
use App\Entity\Lait;
use App\Entity\Pate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher',
                    'class' => ' font-bold rounded-r-lg  block w-full p-2.5 bg-stone-700 border-stone-600 placeholder-stone-400 text-white focus:ring-stone-500 focus:border-stone-500'
                ]
            ])
            ->add('lait', EntityType::class,[
                'label' => 'Laits',
                'required' => false,
                'class' => Lait::class,
                'expanded' => true,
                'multiple' => true,

            ])
            ->add('pates', EntityType::class,[
                'label' => 'Pates',
                'required' => false,
                'class' => Pate::class,
                'expanded' => true,
                'multiple' => true,

            ])
            ->add('animals', EntityType::class,[
                'label' => 'Animaux',
                'required' => false,
                'class' => Animal::class,
                'expanded' => true,
                'multiple' => true,
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'data_class' => SearchData::class,
           'method' => 'GET',
           'csrf_protection' => true
       ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}