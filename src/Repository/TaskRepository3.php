<?php
/**
 * Tea repository.
 */

namespace Repository;

use App\Entity\Category;
use App\Entity\Tea;
use App\Entity\User;
use App\Repository\NonUniqueResultException;
use App\Repository\NoResultException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
class TeaRepository3 extends ServiceEntityRepository
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
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('tea', 'category')
            ->join('tea.category', 'category')
            ->orderBy('tea.updatedAt', 'DESC');
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
     * Query teas by author.
     *
     * @param User $user User entity
     *
     * @return QueryBuilder Query builder
     */
    public function queryByAuthor(User $user): QueryBuilder
    {
        $queryBuilder = $this->queryAll();

        $queryBuilder->andWhere('tea.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
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
}
