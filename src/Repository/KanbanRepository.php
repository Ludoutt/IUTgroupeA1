<?php

namespace App\Repository;

use App\Entity\Kanban;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Kanban|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kanban|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kanban[]    findAll()
 * @method Kanban[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanbanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Kanban::class);
    }
    public function findLast()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Kanban[] Returns an array of Kanban objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kanban
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
