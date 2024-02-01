<?php

namespace App\Form;

use App\Entity\Message;
use PHPUnit\TextUI\XmlConfiguration\Logging\TestDox\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,  ['required' => false, 'attr' => ['class' => 'email'], 'label'=>false])
            ->add(Message::EMAIL_HIDDEN_INPUT, EmailType::class,
            [
                 'label' => 'Email :',
             ])
            ->add('objet', TextType::class, array(
                'label' => 'Objet :',
            ))
            ->add('commentaire', TextareaType::class, array(
                'label' => 'Commentaire :',

                'attr' => [
                    'rows' => '10',
                 ]
            ));
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
