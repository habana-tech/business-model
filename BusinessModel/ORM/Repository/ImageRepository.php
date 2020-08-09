<?php

namespace HabanaTech\BusinessModel\ORM\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use HabanaTech\BusinessModel\ORM\Entity\Image;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,
            \HabanaTech\BusinessModel\ORM\Entity\Image::class);
    }

    /**
     * @param $amount
     * @return Image[] Returns an array of Image objects
     */
    public function getAmount($amount): array
    {
        return $this->createQueryBuilder('i')
            ->orderBy('s.id', 'ASC')
            ->setMaxResults($amount)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Image
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
