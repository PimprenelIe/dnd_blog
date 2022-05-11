<?php

namespace App\Repository\Blog;

use App\Entity\Blog\Category;
use App\Entity\Blog\Keyword;
use App\Entity\Blog\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql\Date;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }


    public function featuredPosts(Post $post, int $limit = 3)
    {
        $qb = $this->createQueryBuilder('post')
            ->where('post.id <> :post')
            ->setParameter('post', $post)
            ->orderBy('RAND()')
            ->setMaxResults($limit);

        $this->addConditions($qb);
        return $qb ->getQuery()->getResult();
    }

    public function findWithDateBy(array $criteria, array $orderBy = null, $limit = null, $offset = null){

        return $this->queryWithDateBy($criteria, $orderBy, $limit, $offset)
            ->getQuery()->getResult();

    }

    public function queryWithDateBy(array $criteria, array $orderBy = null, $limit = null, $offset = null){
        $qb =  $this->createQueryBuilder('post');

        $this->addConditions($qb);

        if(!empty($criteria)){
            foreach($criteria as $criterion => $value){
                    $qb->andWhere("post.".$criterion." = '".$value."'");
            }
        }

        if(!empty($orderBy)){
            foreach($orderBy as $key => $value){
                $qb->addOrderBy("post.".$key,$value);
            }
        }

        if(!empty($limit)){
            $qb->setMaxResults($limit);
        }
        if(!empty($offset)){
            $qb->setFirstResult($offset);
        }

        return $qb;
    }

    public function findByCategory(Category $category){
        return $this->queryByCategory($category)
            ->getQuery()->getResult();
    }

    public function queryByCategory(Category $category){
        $qb = $this->createQueryBuilder('post')
            ->innerJoin('post.categories', 'category')
            ->where('category.id IN (:category)')
            ->setParameters(array('category' => $category));
        $this->addConditions($qb);
        return $qb;
    }

    public function findByKeyword(Keyword $keyword){
        return $this->queryByKeyword($keyword)
            ->getQuery()->getResult();
    }

    public function queryByKeyword(Keyword $keyword){
       $qb = $this->createQueryBuilder('post')
            ->innerJoin('post.keywords', 'keyword')
            ->where('keyword.id IN (:keyword)')
            ->setParameters(array('keyword' => $keyword))
            ;
        $this->addConditions($qb);
       return $qb;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Post $entity, bool $flush = true): void
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
    public function remove(Post $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    private function addConditions(QueryBuilder $queryBuilder){
        $queryBuilder->andWhere('post.publishedAt < :date')
            ->setParameter('date', new \DateTime());

    }

}
