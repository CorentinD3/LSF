<?php

namespace App\Controller\Admin;

use App\Entity\Fromage;
use App\Entity\Label;
use App\Entity\Animal;
use App\Entity\Lait;
use App\Entity\Message;
use App\Entity\Pate;
use App\Entity\Provenance;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Les saveurs fromagères')
            ->setFaviconPath('img/lsf.ico');
            
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Menu', 'fa fa-home');
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-arrow-left', 'app_home');

        yield MenuItem::section('Produits');
        yield MenuItem::linkToCrud('Fromage', 'fas fa-cheese', Fromage::class);
        yield MenuItem::linkToCrud('Animal', 'fas fa-plus', Animal::class);
        yield MenuItem::linkToCrud('Lait', 'fas fa-plus', Lait::class);
        yield MenuItem::linkToCrud('Label', 'fas fa-plus', Label::class);
        yield MenuItem::linkToCrud('Pâte', 'fas fa-plus', Pate::class);
        yield MenuItem::linkToCrud('Provenance', 'fas fa-plus', Provenance::class);
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Compte', 'fas fa-user', User::class);
        yield MenuItem::section('Contact');
        yield MenuItem::linkToCrud('Message', 'fas fa-envelope', Message::class);

        
  






    }
}
