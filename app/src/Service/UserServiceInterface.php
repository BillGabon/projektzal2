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
    /**
     * change password function.
     */
    public function changePassword(User $user, string $newPassword): void;

    /**
     * change email function.
     */
    public function changeEmail(User $user, string $newEmail): void;
}
