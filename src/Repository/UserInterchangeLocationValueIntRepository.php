<?php

namespace App\Repository;

use App\Entity\UserInterchangeLocationValueInt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserInterchangeLocationValueInt|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserInterchangeLocationValueInt|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInterchangeLocationValueInt[]    findAll()
 * @method UserInterchangeLocationValueInt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserInterchangeLocationValueIntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInterchangeLocationValueInt::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UserInterchangeLocationValueInt $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(UserInterchangeLocationValueInt $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return UserInterchangeLocationValueInt[] Returns an array of UserInterchangeLocationValueInt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserInterchangeLocationValueInt
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
