<?php
/**
 * Tea repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Tea;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TeaRepository.
 *
 * @method Tea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tea[]    findAll()
 * @method Tea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Tea>
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 */
class TeaRepository extends ServiceEntityRepository
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
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tea::class);
    }

    /**
     * Query teas by author.
     *
     * @param User                  $user    User entity
     * @param array<string, object> $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryByAuthor(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('tea.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @param array<string, object> $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial tea.{id, createdAt, updatedAt, title, description}',
                'partial category.{id, title}',
                'partial tags.{id, title}'
            )
            ->join('tea.category', 'category')
            ->leftJoin('tea.tags', 'tags')
            ->orderBy('tea.updatedAt', 'DESC');

        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    /**
     * Count teas by category.
     *
     * @param Category $category Category
     *
     * @return int Number of teas in category
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('tea.id'))
            ->where('tea.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count teas by user.
     *
     * @param User $user User
     *
     * @return int Number of teas user has
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByUser(User $user): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('tea.id'))
            ->where('tea.author = :author')
            ->setParameter(':author', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Delete entity.
     *
     * @param Tea $tea Tea entity
     */
    public function delete(Tea $tea): void
    {
        $this->_em->remove($tea);
        $this->_em->flush();
    }

    /**
     * Save entity.
     *
     * @param Tea $tea Tea entity
     */
    public function save(Tea $tea): void
    {
        $this->_em->persist($tea);
        $this->_em->flush();
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
        return $queryBuilder ?? $this->createQueryBuilder('tea');
    }

    /**
     * Apply filters to paginated list.
     *
     * @param QueryBuilder          $queryBuilder Query builder
     * @param array<string, object> $filters      Filters array
     *
     * @return QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }
        if (isset($filters['tag']) && $filters['tag'] instanceof Tag) {
            $queryBuilder->andWhere('tags IN (:tag)')
                ->setParameter('tag', $filters['tag']);
        }

        return $queryBuilder;
    }
}
