<?php

namespace App\Repository;

use App\Entity\Technic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Technic>
 *
 * @method Technic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Technic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Technic[]    findAll()
 * @method Technic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Technic::class);
    }

//    /**
//     * @return Technic[] Returns an array of Technic objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Technic
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
