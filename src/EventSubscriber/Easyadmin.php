<?php

namespace App\EventSubscriber;

use App\Entity\Fromage;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Transliterator;

class Easyadmin implements EventSubscriberInterface
{
    private $tokenStorage;
    private $slugger;
    private $passwordEncoder;
    private $entityManager;

    public function __construct(
                                EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $passwordEncoder,
                                TokenStorageInterface $tokenStorage
                                )
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [

            BeforeEntityPersistedEvent::class=>['create'],
            BeforeEntityDeletedEvent::class=>['delete'],
            BeforeEntityUpdatedEvent::class => ['update'],
        ];
    }
   

    public function delete(BeforeEntityDeletedEvent $event){

        $entity = $event->getEntityInstance();
        $user = $this->tokenStorage->getToken()->getUser();

        if ($entity instanceof User) {
            if ($entity->getPseudo() == $user->getUserIdentifier()) {
                session_destroy();
            }
        }

        if ($entity instanceof Fromage) {

            $entity->setDisplay(1);

            $image = $entity->getImage();

            $fichier = "uploads/fromages/$image";

            unlink($fichier);
        }
     }

    public function update(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (($entity instanceof User)) {
            if($entity->getPassword() == null){
                $this->setPassword($entity);
        }}

        if(($entity instanceof Fromage)) {
            $transliterator = Transliterator::create("NFD; [:Nonspacing Mark:] Remove; NFC");
            $nom = $transliterator->transliterate($entity->getNom());
            // Remplacez les espaces par des tirets
            $slug = strtolower(str_replace(' ', '-', $nom));
            $entity->setSlug($slug);

        }
    }

    public function create(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (($entity instanceof User)) {
            $this->setPassword($entity);
        }
        if(($entity instanceof Fromage)) {
            $entity->setDisplay(1);

        }

        if (($entity instanceof Fromage)) {

            $transliterator = Transliterator::create("NFD; [:Nonspacing Mark:] Remove; NFC");

            $nom = $transliterator->transliterate($entity->getNom());
            $entity->setSlug($nom);
        }
   

        
    }

   /**
       * @param User $entity
       */
      public function setPassword(User $entity): void
      {
          $pass = $entity->getPassword();

          $entity->setPassword(
              $this->passwordEncoder->encodePassword(
                  $entity,
                  $pass
              )
          );
          $this->entityManager->persist($entity);
          $this->entityManager->flush();
      }

}

