<?php

namespace App\Repository;

use App\Entity\PostCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostCard>
 *
 * @method PostCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostCard[]    findAll()
 * @method PostCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostCard::class);
    }

//    /**
//     * @return PostCard[] Returns an array of PostCard objects
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

//    public function findOneBySomeField($value): ?PostCard
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
