<?php

namespace App\Repository;

use App\Entity\GroupFitnessClasses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupFitnessClasses|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupFitnessClasses|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupFitnessClasses[]    findAll()
 * @method GroupFitnessClasses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupFitnessClassesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupFitnessClasses::class);
    }

    // /**
    //  * @return GroupFitnessClasses[] Returns an array of GroupFitnessClasses objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupFitnessClasses
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
