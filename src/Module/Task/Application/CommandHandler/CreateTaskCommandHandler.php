<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 12/03/17
 * Time: 0:44
 */

namespace App\Module\SubModule\Application\CommandHandler\Task;


use App\Module\SubModule\Application\Command\CommandInterface;
use App\Module\SubModule\Application\Command\Task\CreateTaskCommand;
use App\Module\SubModule\Application\CommandHandler\CommandHandlerInterface;
use App\Module\SubModule\Domain\Entity\Task\Task;
use App\Module\SubModule\Domain\Entity\Task\TaskRepositoryInterface;
use App\Module\SubModule\Domain\Entity\User\Exception\UserDoesNotExistsException;
use App\Module\SubModule\Domain\Entity\User\User;
use App\Module\SubModule\Domain\Entity\User\UserRepositoryInterface;

class CreateTaskCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * CreateTaskCommandHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                TaskRepositoryInterface $taskRepository)
    {
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     *
     * @param CommandInterface|CreateTaskCommand $command
     * @return mixed
     * @throws UserDoesNotExistsException
     */
    public function execute(CommandInterface $command)
    {
        /** @var User $user */
        $user = $this->userRepository->find($command->user());
        if (null == $user) {
            throw new UserDoesNotExistsException();
        }
        $task = Task::build($command->title(), $user, Task::OPEN, $command->description());
        $this->taskRepository->add($task);
    }
}