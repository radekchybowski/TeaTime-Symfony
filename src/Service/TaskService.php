<?php
/**
 * Task service.
 */

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TaskService.
 */
class TaskService implements TaskServiceInterface
{
    /**
     * Task repository.
     */
    private TaskRepository $taskRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param TaskRepository     $taskRepository Task repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(TaskRepository $taskRepository, PaginatorInterface $paginator)
    {
        $this->taskRepository = $taskRepository;
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
            $this->taskRepository->queryAll(),
            $page,
            TaskRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Task $task Task entity
     */
    public function save(Task $task): void
    {
        $this->taskRepository->save($task);
    }

    /**
     * Delete entity.
     *
     * @param Task $task Task entity
     */
    public function delete(Task $task): void
    {
        $this->taskRepository->delete($task);
    }
}
