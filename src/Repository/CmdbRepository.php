<?php

namespace App\Repository;

use App\Entity\Cmdb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cmdb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cmdb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cmdb[]    findAll()
 * @method Cmdb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CmdbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cmdb::class);
    }

    // /**
    //  * @return Cmdb[] Returns an array of Cmdb objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cmdb
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
