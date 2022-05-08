<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 *
 * @method Visite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visite[]    findAll()
 * @method Visite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Visite $entity, bool $flush = true): void
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
    public function remove(Visite $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findNbVisiteLastDays(int $days = 7){
        /**
        SELECT COUNT(id), DATE_FORMAT(date, '%Y-%m-%d') as dateFormat
        FROM visite
        WHERE date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()
        GROUP BY DATE_FORMAT(date, '%Y-%m-%d')
        ORDER BY dateFormat  DESC;
         */
        $days = $days - 1;

        $now = new \DateTime("+1 days");
        $previous = new \DateTime("-$days days");

        return $this->createQueryBuilder('visit')
            ->select("count(visit.id) as nbVisit, DATE_FORMAT(visit.date, '%Y-%m-%d') as dateFormat")
            ->andWhere("visit.date BETWEEN :begin AND :end")
            ->setParameter('begin', $previous->format('Y-m-d'))
            ->setParameter('end', $now->format('Y-m-d'))
            ->groupBy("dateFormat")
            ->orderBy('dateFormat', 'DESC')
            ->getQuery()->getResult();
    }


}
