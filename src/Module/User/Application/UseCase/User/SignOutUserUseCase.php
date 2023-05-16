<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 18/02/17
 * Time: 18:35
 */

namespace App\Module\SubModule\Application\UseCase\User;

use Silex\Application;
use App\Module\SubModule\Domain\Service\User\UserAuthentifierService;

class SignOutUserUseCase
{

    /**
     * @var Application
     */
    private $application;

    /**
     * SignOutUserUseCase constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Remove session use case
     */
    public function execute()
    {
       $this->application['session']->clear();
    }
}
