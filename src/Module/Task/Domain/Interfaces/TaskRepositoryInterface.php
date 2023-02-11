<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 11/03/17
 * Time: 23:23
 */

namespace App\Module\SubModule\Domain\Entity\Task;

use App\Module\SubModule\Domain\ValueObject\User\UserId;

interface TaskRepositoryInterface
{
    /**
     * @param $taskId
     * @return Task
     */
    public function fetchById($taskId);

    /**
     * Fetch only available tasks given user
     *
     * @param UserId $userId
     * @return mixed
     */
    public function fetchAvailable(UserId $userId);
}
