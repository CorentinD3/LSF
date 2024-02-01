<?php

namespace App\Command;

use App\Entity\Fromage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Transliterator;

class UpdateFromageSlugsCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('app:fromage:update-slugs')
            ->setDescription('Mise à jour des slugs pour les fromages existants');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->em->getRepository(Fromage::class);
        $fromages = $repository->findAll();

        foreach ($fromages as $fromage) {
            $nom = $fromage->getNom();
            // Créez un translittérateur pour la normalisation et la conversion
            $transliterator = Transliterator::create("NFD; [:Nonspacing Mark:] Remove; NFC");

            // Appliquez le translittérateur au nom pour convertir les caractères accentués en caractères non accentués
            $nom = $transliterator->transliterate($nom);

            // Remplacez les espaces par des tirets
            $slug = strtolower(str_replace(' ', '-', $nom));

            $fromage->setSlug($slug);
        }

        $this->em->flush();

        $output->writeln('Les slugs des fromages ont été mis à jour avec succès.');

        return Command::SUCCESS;
    }
}