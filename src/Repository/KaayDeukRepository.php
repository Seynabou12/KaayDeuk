<?php

namespace App\Repository;

use App\Entity\KaayDeuk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KaayDeuk|null find($id, $lockMode = null, $lockVersion = null)
 * @method KaayDeuk|null findOneBy(array $criteria, array $orderBy = null)
 * @method KaayDeuk[]    findAll()
 * @method KaayDeuk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KaayDeukRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KaayDeuk::class);
    }

    // /**
    //  * @return KaayDeuk[] Returns an array of KaayDeuk objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KaayDeuk
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
