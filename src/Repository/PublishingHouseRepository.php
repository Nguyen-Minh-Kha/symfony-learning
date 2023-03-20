<?php

namespace App\Repository;

use App\DTO\SearchPublishingHouseCriteria;
use App\Entity\PublishingHouse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PublishingHouse>
 *
 * @method PublishingHouse|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublishingHouse|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublishingHouse[]    findAll()
 * @method PublishingHouse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublishingHouseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublishingHouse::class);
    }

    public function save(PublishingHouse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PublishingHouse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find by criteria 
     */
    public function findByCriteria(SearchPublishingHouseCriteria $criteria): array
    {
        $qd = $this->createQueryBuilder('house');

        if ($criteria->name) {
            $qd->andWhere('house.name LIKE :name')
                ->setParameter('name', "%$criteria->name%");
        }

        if($criteria->country){
            $qd->andWhere('house.country LIKE :country')
               ->setParameter('country', "%$criteria->country%");
        }

        $qd->orderBy("house.$criteria->orderBy", $criteria->direction);

        return $qd->getQuery()->getResult();
    }

//    /**
//     * @return PublishingHouse[] Returns an array of PublishingHouse objects
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

//    public function findOneBySomeField($value): ?PublishingHouse
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
