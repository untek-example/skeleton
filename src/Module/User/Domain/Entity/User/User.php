<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 10/02/17
 * Time: 19:28
 */

namespace App\Module\SubModule\Domain\Entity\User;

use App\Module\SubModule\Domain\Entity\Task\Task;
use App\Module\SubModule\Domain\Event\DomainEventDispatcher;
use App\Module\SubModule\Domain\Event\User\UserRegistered;
use App\Module\SubModule\Domain\ValueObject\Email\Email;
use App\Module\SubModule\Domain\ValueObject\Password\Password;
use App\Module\SubModule\Domain\ValueObject\User\UserId;

class User
{
    /**
     * @var UserId $uid
     */
    private $uid;

    /**
     * @var string
     */
    private $username;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var array
     */
    private $tasks;

    /**
     * @var \DateTime
     */
    protected $createdOn;
    /**
     * @var \DateTime
     */
    protected $updatedOn;


    /**
     * User constructor.
     *
     * @param UserId $userId
     * @param string $userName
     * @param string $email
     * @param string $passwd
     */
    public function __construct(UserId $userId, string $userName, string $email, string $passwd)
    {
        $this->uid = $userId;
        $this->username = $userName;
        $this->email = Email::fromString($email);
        $this->password = Password::fromString($passwd);
        $this->createdOn = new \DateTime();
        $this->updatedOn = new \DateTime();
        $this->dispatchUserWasRegisteredEvent();
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->uid;
    }

    /**
     * @return Password
     */
    public function password(): Password
    {
        return $this->password;
    }

    /**
     * Change password
     *
     * @param string $password
     */
    public function changePassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function tasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task)
    {
        $this->tasks[] = $task;
    }

    /**
     *  Dispatch event of user registered
     */
    protected function dispatchUserWasRegisteredEvent()
    {
        DomainEventDispatcher::instance()->dispatch(
            new UserRegistered(
                $this->id(),
                $this->email(),
                $this->username()
            )
        );
    }
}
