<?php
/**
 * License Block.
 */

namespace App\Service;

use App\Entity\User;

/**
 * Service interface for user.
 */
interface UserServiceInterface
{
    /** Change password.
     * @param User   $user        user
     * @param string $newPassword new Password
     */
    public function changePassword(User $user, string $newPassword): void;

    /** Change Email function.
     * @param User   $user     user
     * @param string $newEmail new Email
     */
    public function changeEmail(User $user, string $newEmail): void;
}
