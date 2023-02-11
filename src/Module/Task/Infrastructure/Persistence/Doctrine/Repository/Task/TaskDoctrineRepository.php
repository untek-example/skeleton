<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 11/03/17
 * Time: 23:22
 */

namespace App\Module\SubModule\Infrastructure\Persistence\Doctrine\Repository\Task;

use Doctrine\ORM\EntityRepository;
use App\Module\SubModule\Domain\Entity\Task\Task;
use App\Module\SubModule\Domain\Entity\Task\TaskRepositoryInterface;
use App\Module\SubModule\Domain\ValueObject\User\UserId;
use App\Module\SubModule\Infrastructure\Persistence\Doctrine\Repository\AbstractEntityRepository;

class TaskDoctrineRepository extends AbstractEntityRepository implements TaskRepositoryInterface
{
    /**
     * @param Task $task
     * @return mixed|void
     */
    public function add(Task $task)
    {
        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();
    }

    /**
     * @param $taskId
     * @return mixed
     */
    public function fetchById($taskId)
    {
        return $this->getEntityManager()->find(Task::class, $taskId);
    }

    /**
     * Fetch only available tasks given user
     *
     * @param UserId $userId
     * @return mixed
     */
    public function fetchAvailable(UserId $userId)
    {
        return $this->fetchBy([
            'userAssigned' => $userId->id(),
            'status' => Task::OPEN
        ]);
    }
}
