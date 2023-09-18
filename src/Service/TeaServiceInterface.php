<?php
/**
 * Tea service interface.
 */

namespace App\Service;

use App\Entity\Tea;
use App\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface TeaServiceInterface.
 */
interface TeaServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int  $page   Page number
     * @param User $author Author
     *
     * @return PaginationInterface Paginated list
     */
    public function getPaginatedList(int $page, User $author): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Tea $tea Tea entity
     */
    public function save(Tea $tea): void;

    /**
     * Delete entity.
     *
     * @param Tea $tea Tea entity
     */
    public function delete(Tea $tea): void;

    /**
     * Find by id.
     *
     * @param int $id Tea id
     *
     * @return Tea|null Tea entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Tea;

    /**
     * Delete all teas where User is author.
     *
     * @param User $user User
     *
     * @return void
     */
    public function deleteTeaByAuthor(User $user): void;
}
