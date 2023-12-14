<?php

namespace App\Repository;

use App\Entity\TechniqueUsed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechniqueUsed>
 *
 * @method TechniqueUsed|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechniqueUsed|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechniqueUsed[]    findAll()
 * @method TechniqueUsed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechniqueUsedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechniqueUsed::class);
    }

//    /**
//     * @return TechniqueUsed[] Returns an array of TechniqueUsed objects
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

//    public function findOneBySomeField($value): ?TechniqueUsed
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
