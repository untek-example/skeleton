<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 12/02/17
 * Time: 13:07
 */

namespace App\Module\SubModule\Application\Command\User;


use App\Module\SubModule\Application\Command\CommandInterface;
use App\Module\SubModule\Application\CommandHandler\User\SignInUserCommandHandler;

class SignInUserCommand implements CommandInterface

{
    /**
     * @var $email
     */
    private $email;

    /**
     * @var $password
     */
    private $password;

    /**
     * SignInUserRequest constructor.
     * @param $email
     * @param $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function commandHandler(): string
    {
        return 'signin.service';
    }
}
