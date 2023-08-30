<?php
/**
 * Tea service interface.
 */

namespace App\Service;

use App\Entity\Tea;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface TeaServiceInterface.
 */
interface TeaServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
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
}