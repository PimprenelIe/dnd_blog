<?php

namespace App\Repository\Media;

use App\Entity\Media\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 *
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Media $entity, bool $flush = true): void
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
    public function remove(Media $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findAutocompleteMediaPicker(string $search){

        $qb = $this->createQueryBuilder('media');

        $qb->select('media.id, media.fileName')
            ->orderBy('media.updatedAt', 'DESC')
            ->setMaxResults(6);

        if(!empty($search)){
            $qb->andWhere('media.fileName LIKE :search')
                ->setParameter('search', "%".$search."%");
        }

        return $qb->getQuery()->getResult();

    }
}
