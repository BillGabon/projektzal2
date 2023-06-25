<?php
/**
 * Ad repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AdRepository.
 *
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Ad>
 */
class AdRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 3;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial ad.{id, createdAt, updatedAt, title}',
                'partial category.{id, name}'
            )
            ->join('ad.category', 'category')
            ->orderBy('ad.updatedAt', 'DESC');
    }

    /**
     * Count ads by category.
     *
     * @param Category $category Category
     *
     * @return int Number of ads in category
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('ad.id'))
            ->where('ad.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }
    /**
     * Save entity.
     *
     * @param Ad $ad ad entity
     */
    public function save(ad $ad): void
    {
        $this->_em->persist($ad);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Ad $ad ad entity
     */
    public function delete(Ad $ad): void
    {
        $this->_em->remove($ad);
        $this->_em->flush();
    }
    /**
     * Find ads by category.
     *
     * @param Category $category Category
     *
     * @return Ad[] Ads in category
     */
    public function findByCategory(Category $category): array
    {
        return $this->createQueryBuilder('ad')
            ->where('ad.category = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }
    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('ad');
    }
}
