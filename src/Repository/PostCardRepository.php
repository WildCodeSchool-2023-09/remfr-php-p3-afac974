<?php

namespace App\Repository;

use App\Entity\Postcard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Postcard>
 *
 * @method Postcard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postcard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postcard[]    findAll()
 * @method Postcard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostcardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postcard::class);
    }

//    /**
//     * @return Postcard[] Returns an array of Postcard objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Postcard
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
