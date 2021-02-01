<?php

namespace App\Repository;

use App\Entity\OtherAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OtherAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method OtherAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method OtherAction[]    findAll()
 * @method OtherAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtherActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OtherAction::class);
    }

    // /**
    //  * @return OtherAction[] Returns an array of OtherAction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OtherAction
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
