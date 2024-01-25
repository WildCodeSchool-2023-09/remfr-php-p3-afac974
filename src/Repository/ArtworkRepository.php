<?php

namespace App\Repository;

use App\Entity\Type;
use App\Entity\Artwork;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Artwork>
 *
 * @method Artwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artwork[]    findAll()
 * @method Artwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
    }

    public function queryFindAllArtwork(): Query
    {
        return $this->createQueryBuilder(alias:'a')->orderBy('a.id', 'ASC')->getQuery();
    }

    public function findLikeTitle(string $search, ?Type $type): Query
    {
        $query = $this->createQueryBuilder('a')
            ->join('a.type', 'at')
            ->andWhere('a.title LIKE :search')
            ->setParameter('search', '%' . $search . '%');

        if ($type) {
            $query
                ->andWhere('a.type = :type')
                ->setParameter('type', $type);
        }

        return $query->getQuery();
    }
//    /**
//     * @return Artwork[] Returns an array of Artwork objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Artwork
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
