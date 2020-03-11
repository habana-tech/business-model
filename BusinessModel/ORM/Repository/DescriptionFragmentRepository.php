<?php

namespace HabanaTech\BusinessModel\ORM\Repository;

use HabanaTech\BusinessModel\ORM\Entity\DescriptionFragment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DescriptionFragment|null find($id, $lockMode = null, $lockVersion = null)
 * @method DescriptionFragment|null findOneBy(array $criteria, array $orderBy = null)
 * @method DescriptionFragment[]    findAll()
 * @method DescriptionFragment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptionFragmentRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DescriptionFragment::class);
    }

    // /**
    //  * @return DescriptionFragment[] Returns an array of DescriptionFragment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DescriptionFragment
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
