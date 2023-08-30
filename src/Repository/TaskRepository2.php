<?php
//
//namespace Repository;
//
//use App\Entity\Tea;
//use App\Repository\QueryBuilder;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<Tea>
// *
// * @method Tea|null find($id, $lockMode = null, $lockVersion = null)
// * @method Tea|null findOneBy(array $criteria, array $orderBy = null)
// * @method Tea[]    findAll()
// * @method Tea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
// */
//class TeaRepository2 extends ServiceEntityRepository
//{
//    /**
//     * Items per page.
//     *
//     * Use constants to define configuration options that rarely change instead
//     * of specifying them in configuration files.
//     * See https://symfony.com/doc/current/best_practices.html#configuration
//     *
//     * @constant int
//     */
//    public const PAGINATOR_ITEMS_PER_PAGE = 5;
//
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Tea::class);
//    }
//
//    /**
//     * Query all records.
//     *
//     * @return QueryBuilder Query builder
//     */
//    public function queryAll(): QueryBuilder
//    {
//        return $this->getOrCreateQueryBuilder()
//            ->orderBy('tea.updatedAt', 'DESC');
//    }
//
//    /**
//     * Get or create new query builder.
//     *
//     * @param QueryBuilder|null $queryBuilder Query builder
//     *
//     * @return QueryBuilder Query builder
//     */
//    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
//    {
//        return $queryBuilder ?? $this->createQueryBuilder('tea');
//    }
//
//    public function save(Tea $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->persist($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }
//
//    public function remove(Tea $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->remove($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }
//
//    public function getAllTeas() {
//        return $this->findAll();
//    }
////    /**
////     * @return Tea[] Returns an array of Tea objects
////     */
////    public function findByExampleField($value): array
////    {
////        return $this->createQueryBuilder('t')
////            ->andWhere('t.exampleField = :val')
////            ->setParameter('val', $value)
////            ->orderBy('t.id', 'ASC')
////            ->setMaxResults(10)
////            ->getQuery()
////            ->getResult()
////        ;
////    }
//
////    public function findOneBySomeField($value): ?Tea
////    {
////        return $this->createQueryBuilder('t')
////            ->andWhere('t.exampleField = :val')
////            ->setParameter('val', $value)
////            ->getQuery()
////            ->getOneOrNullResult()
////        ;
////    }
//}
