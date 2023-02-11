<?php

namespace App\Module\SubModule\Domain\Entity\Task;

use DateTime;
use App\Module\SubModule\Domain\Entity\Task\Exception\TaskStatusDoesNotExistsException;
use App\Module\SubModule\Domain\Entity\User\User;
use App\Module\SubModule\Domain\Event\DomainEventDispatcher;
use App\Module\SubModule\Domain\Event\Task\TaskWasCreated;
use App\Module\SubModule\Domain\ValueObject\Task\TaskId;

class Task
{
    const OPEN = 'open';
    const CLOSED = 'closed';
    const REMOVED = 'removed';

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var User $userAssigned
     */
    private $userAssigned;

    /**
     * @var string $status
     */
    private $status;

    /**
     * @var string
     */
    private $description;

    /**
     * @var datetime
     */
    private $createdOn;

    /**
     * @var datetime
     */
    private $updatedOn;

    /**
     * Task constructor.
     *
     * @param string $title
     * @param User $user
     * @param string $status
     * @param string $description
     */
    private function __construct(string $title, User $user, string $status, string $description)
    {
        $this->id = TaskId::generate();
        $this->title = $title;
        $this->userAssigned = $user;
        $this->setStatus($status);
        $this->description = $description;
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
        DomainEventDispatcher::instance()->dispatch(
            new TaskWasCreated(
                $this->id,
                $this->title(),
                $this->description(),
                $this->userAssigned()
            )
        );
    }

    /**
     * Build new Task instance
     *
     * @param string $title
     * @param User $user
     * @param string $status
     * @param string $description
     * @return Task
     */
    public static function build(string $title, User $user, string $status, string $description)
    {
        return new self($title, $user, $status, $description);
    }

    /**
     * @return int|TaskId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Set a task removed
     */
    public function remove()
    {
        $this->status = self::REMOVED;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return User
     */
    public function userAssigned(): User
    {
        return $this->userAssigned;
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function createdOn(): \DateTimeImmutable
    {
        return $this->createdOn;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function updatedOn(): \DateTimeImmutable
    {
        return $this->updatedOn;
    }

    /**
     * @param string $status
     * @throws TaskStatusDoesNotExistsException
     */
    public function setStatus(string $status)
    {
        if ($status !== self::OPEN && $status !== self::CLOSED) {
            throw new TaskStatusDoesNotExistsException();
        }

        $this->status = $status;
    }
}
