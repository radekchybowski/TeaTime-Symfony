<?php
/**
 * Tag service.
 */

namespace App\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TagService.
 */
class TagService implements TagServiceInterface
{
    /**
     * Tag repository.
     */
    private TagRepository $repository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param TagRepository      $tagRepository Tea repository
     * @param PaginatorInterface $paginator     Paginator
     */
    public function __construct(TagRepository $tagRepository, PaginatorInterface $paginator)
    {
        $this->repository = $tagRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->repository->queryAll(),
            $page,
            TagRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get tag by id.
     *
     * @param int $id
     *
     * @return Tag|null
     */
    public function getOne(int $id): ?Tag
    {
        return $this->repository->findOneById($id);
    }

    /**
     * Save entity.
     *
     * @param Tag $tag Tag entity
     */
    public function save(Tag $tag): void
    {
        $this->repository->save($tag);
    }

    /**
     * Delete tag instance.
     *
     * @param Tag $tag
     */
    public function delete(Tag $tag): void
    {
        $this->repository->delete($tag);
    }

    /**
     * Find by title.
     *
     * @param string $title Tag title
     *
     * @return Tag|null Tag entity
     */
    public function findOneByTitle(string $title): ?Tag
    {
        return $this->repository->findOneByTitle($title);
    }

    /**
     * Find by id.
     *
     * @param int $id Tag id
     *
     * @return Tag|null Tag entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Tag
    {
        return $this->repository->findOneById($id);
    }
}
