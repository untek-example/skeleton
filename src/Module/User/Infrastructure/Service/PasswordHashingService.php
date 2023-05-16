<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 11/02/17
 * Time: 0:02
 */

namespace App\Module\SubModule\Infrastructure\Service\User;

use App\Module\SubModule\Domain\Service\User\PasswordHashingService as PasswordHashingServiceInterface;
use App\Module\SubModule\Domain\ValueObject\Password\Password;

class PasswordHashingService implements PasswordHashingServiceInterface
{

    /**
     * @param Password $password
     *
     * @return mixed
     */
    public function hash(Password $password)
    {
        return sha1($password->password());
    }

    /**
     * @param Password $userPassword
     * @param string $passwordToVerify
     *
     * @return bool
     */
    public function verifyPassword(Password $userPassword, string $passwordToVerify)
    {
        return (sha1($passwordToVerify) == $userPassword->password());
    }
}