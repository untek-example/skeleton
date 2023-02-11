<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 16/03/17
 * Time: 16:16
 */

namespace App\Module\SubModule\Presentation\Controllers\Task;

use Silex\Application;
use App\Module\SubModule\Application\Command\Task\RemoveTaskCommand;

class RemoveTaskController
{
    /**
     * @var Application
     */
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function indexAction()
    {
        $request = $this->application['request_stack']->getCurrentRequest();
        $this->application['removetask.service']->execute(new RemoveTaskCommand(
            $request->get('task')
        ));

        return $this->application->redirect($this->application['url_generator']->generate('listtask'));
    }
}
