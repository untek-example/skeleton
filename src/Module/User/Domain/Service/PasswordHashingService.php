<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 11/02/17
 * Time: 0:00
 */

namespace App\Module\SubModule\Domain\Service\User;

use App\Module\SubModule\Domain\ValueObject\Password\Password;

interface PasswordHashingService
{
    /**
     * @param Password $password
     *
     * @return mixed
     */
    public function hash(Password $password);

    /**
     * @param Password $userPassword
     * @param string $passwordToVerify
     *
     * @return mixed
     */
    public function verifyPassword(Password $userPassword, string $passwordToVerify);
}
