<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 12/03/17
 * Time: 0:36
 */

namespace App\Module\SubModule\Application\Command\Task;


use App\Module\SubModule\Application\Command\CommandInterface;
use App\Module\SubModule\Domain\Entity\User\User;

class CreateTaskCommand implements CommandInterface
{
    /**
     * @var
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $user;

    /**
     * CreateTaskCommand constructor.
     * @param string $title
     * @param string $description
     * @param string $user
     */
    public function __construct(string $title, string $description, string $user)
    {

        $this->title = $title;
        $this->description = $description;
        $this->user = $user;
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
     * @return string
     */
    public function user(): string
    {
        return $this->user;
    }
    /**
     * @return string
     */
    public function commandHandler(): string
    {
        return 'createtask.service';
    }
}
