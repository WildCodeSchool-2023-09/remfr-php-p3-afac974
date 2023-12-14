<?php

namespace App\Repository;

use App\Entity\TypeOfWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeOfWork>
 *
 * @method TypeOfWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOfWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOfWork[]    findAll()
 * @method TypeOfWork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOfWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOfWork::class);
    }

//    /**
//     * @return TypeOfWork[] Returns an array of TypeOfWork objects
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

//    public function findOneBySomeField($value): ?TypeOfWork
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
