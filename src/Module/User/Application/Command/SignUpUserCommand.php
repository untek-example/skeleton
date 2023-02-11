<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 18/02/17
 * Time: 0:29
 */

namespace App\Module\SubModule\Application\Command\User;

use App\Module\SubModule\Application\Command\CommandInterface;

class SignUpUserCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * SignUpUserCommand constructor.
     *
     * @param string $userName
     * @param string $email
     * @param $password
     */
    public function __construct(string $userName, string $email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->username = $userName;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function commandHandler(): string
    {
       return 'signup.service';
    }
}
