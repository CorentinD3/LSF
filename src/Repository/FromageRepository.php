<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Fromage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @extends ServiceEntityRepository<Fromage>
 *
 * @method Fromage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fromage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fromage[]    findAll()
 * @method Fromage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FromageRepository extends ServiceEntityRepository
{

    public function findOneBySlug($slug): ?Fromage
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.Slug = :val')
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Fromage::class);

        $this->paginator = $paginator;
    }

    public function add(Fromage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fromage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Fromage[] Returns an array of Fromage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fromage
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    /**
     * Récupère les produits en lien avec une recherche
     * @param SearchData $data
     * @return PaginationInterface
     */
    public function findSearch(SearchData $data): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('l', 'p', 'pa', 'pl')
            ->join('p.Animal', 'l')
            ->join('p.lait', 'pl')
            ->join('p.Pate', 'pa')
            ->where('p.display = 1');

        if (!empty($data->q)){
            $query = $query
                ->andWhere('p.nom LIKE :q')
                ->setParameter('q', "%{$data->q}%");
        }

        if (!empty($data->animals)) {
            $query = $query
                ->andWhere('l.id IN (:animals)')
                ->setParameter('animals', $data->animals);
        }

        if (!empty($data->lait)) {
            $query = $query
                ->andWhere('pl.id IN (:lait)')
                ->setParameter('lait', $data->lait);
        }

        if (!empty($data->pates)) {
            $query = $query
                ->andWhere('pa.id IN (:pates)')
                ->setParameter('pates', $data->pates);
        }

        $query = $query->getQuery();

        return $this->paginator->paginate(
            $query,
            $data->page,
            15
        );
    }
}
