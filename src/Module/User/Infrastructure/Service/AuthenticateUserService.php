<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 18/02/17
 * Time: 13:37
 */

namespace App\Module\SubModule\Infrastructure\Service\User;

use App\Module\SubModule\Domain\Entity\User\User;
use App\Module\SubModule\Domain\Service\User\UserAuthentifierService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthenticateUserService implements UserAuthentifierService
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * AuthenticateUserService constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Authenticate an user and store session.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function authenticate(User $user)
    {
        $this->session->start();
        $this->session->set('user', ['username' => $user->username()]);
    }

    /**
     * Remove session
     *
     * @return mixed
     */
    public function removeSession()
    {
       $this->session->clear();
    }
}
