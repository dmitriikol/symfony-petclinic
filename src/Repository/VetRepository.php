<?php

namespace App\Repository;

use App\Entity\Vet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vet[]    findAll()
 * @method Vet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vet::class);
    }

    public function persist(Vet $vet): void
    {
        $this->_em->persist($vet);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function remove(Vet $vet): void
    {
        $this->_em->remove($vet);
        $this->flush();
    }

    public function update(Vet $vet): void
    {
        $this->persist($vet);
        $this->flush();
    }

    // /**
    //  * @return Vet[] Returns an array of Vet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vet
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
