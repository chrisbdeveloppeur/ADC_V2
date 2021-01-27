<?php

namespace App\Repository;

use App\Entity\OtherAsset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OtherAsset|null find($id, $lockMode = null, $lockVersion = null)
 * @method OtherAsset|null findOneBy(array $criteria, array $orderBy = null)
 * @method OtherAsset[]    findAll()
 * @method OtherAsset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtherAssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OtherAsset::class);
    }

    // /**
    //  * @return OtherAsset[] Returns an array of OtherAsset objects
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
    public function findOneBySomeField($value): ?OtherAsset
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
