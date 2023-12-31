<?php

/**
 * Service for user.
 */

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service for User.
 */
class UserService implements UserServiceInterface
{
    private EntityManagerInterface $entityManager;

    /** Constructor.
     * @param EntityManagerInterface $entityManager Entity manager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /** Change password.
     * @param User   $user        user
     * @param string $newPassword new Password
     */
    public function changePassword(User $user, string $newPassword): void
    {
        $passwordToPass = password_hash($newPassword, PASSWORD_DEFAULT);
        $user->setPassword($passwordToPass);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /** Change Email function.
     * @param User   $user     user
     * @param string $newEmail new Email
     */
    public function changeEmail(User $user, string $newEmail): void
    {
        $user->setEmail($newEmail);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
