<?php

namespace App\Repository;

use App\Entity\Weapon;
use App\Entity\WeaponSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Weapon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weapon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weapon[]    findAll()
 * @method Weapon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weapon::class);
    }

        
    /**
     * findLatest
     *
     * @return Weapon[]
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('w')
        ->orderBy('w.id', 'ASC')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult()
    ;
    }

     /**
     * findRange
     *
     * @return Weapon[]
     */
    public function findRange($start, $limit): array
    {
        return $this->createQueryBuilder('w')
        ->orderBy('w.id', 'ASC')
        ->setMaxResults($limit)
        ->setFirstResult($start)
        ->getQuery()
        ->getResult()
    ;
    }
    
    /**
     *
     * @return Query
     */
    public function findAllQuery(WeaponSearch $weaponSearch): Query
    {
        $query = $this->createQueryBuilder('w');
        if($weaponSearch->getSearchName()){
            $query = $query
                ->andWhere('w.name = :name')
                ->setParameter('name', $weaponSearch->getSearchName());
        }
        if($weaponSearch->getSearchDate()){
            $query = $query
                ->andWhere('YEAR(w.created_at) = :date')
                ->setParameter('date', $weaponSearch->getSearchDate());
        }

        if($weaponSearch->getSearchOptions()->count() > 0){
            $k = 0;
            foreach($weaponSearch->getSearchOptions() as $option){
                $k++;
                $query = $query
                ->andWhere(":option$k MEMBER OF w.options")
                ->setParameter("option$k", $option);
            }

        }
        return $query->getQuery();
    }

    // /**
    //  * @return Weapon[] Returns an array of Weapon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Weapon
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
