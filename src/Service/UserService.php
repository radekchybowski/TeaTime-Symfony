<?php
/**
 * User service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\TeaRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterface
{
    /**
     * User repository.
     */
    private UserRepository $userRepository;

    /**
     * Tea repository.
     */
    private TeaRepository $teaRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Constructor.
     *
     * @param UserRepository              $userRepository User repository
     * @param TeaRepository               $teaRepository  Tea repository
     * @param PaginatorInterface          $paginator      Paginator
     * @param UserPasswordHasherInterface $passwordHasher Password hasher
     */
    public function __construct(UserRepository $userRepository, TeaRepository $teaRepository, PaginatorInterface $paginator, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->teaRepository = $teaRepository;
        $this->paginator = $paginator;
        $this->passwordHasher = $passwordHasher;
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
            $this->userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param User $user User entity
     */
    public function save(User $user): void
    {
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );
        $this->userRepository->save($user);
    }

    /**
     * Delete entity.
     *
     * @param User $user User entity
     */
    public function delete(User $user): void
    {
        $this->userRepository->remove($user);
    }

    /**
     * Can User be deleted?
     *
     * @param User $user User entity
     *
     * @return bool Result
     */
    public function canBeDeleted(User $user): bool
    {
        try {
            $result = $this->teaRepository->countByUser($user);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }
}
