<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 16/03/17
 * Time: 16:39
 */

namespace App\Module\SubModule\Application\Command\Task;

use App\Module\SubModule\Application\Command\CommandInterface;

class RemoveTaskCommand implements CommandInterface
{

    /**
     * @var string
     */
    private $taskId;

    /**
     * RemoveTaskCommand constructor.
     * @param string $taskId
     */
    public function __construct(string $taskId)
    {

        $this->taskId = $taskId;
    }

    /**
     * @return string
     */
    public function taskId()
    {
        return $this->taskId;
    }

    /**
     * @return string
     */
    public function commandHandler(): string
    {
        return 'removetask.service';
    }
}