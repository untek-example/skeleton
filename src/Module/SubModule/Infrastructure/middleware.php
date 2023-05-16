<?php

use Silex\Application;
use App\Module\SubModule\Domain\Entity\User\UserSessionNotFoundException;
use App\Module\SubModule\Domain\Event\DomainEventDispatcher;
use App\Module\SubModule\Domain\Event\Task\TaskWasCreated;
use App\Module\SubModule\Domain\Event\User\UserRegistered;
use App\Module\SubModule\Domain\EventListener\LogNewUserOnUserRegistered;
use App\Module\SubModule\Domain\EventListener\SendWelcomeEmailOnUserRegistered;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$isUserLoggedCallback = function (Request $request, Application $app) {
    if (empty($app['session']->get('user'))) {
        throw new UserSessionNotFoundException();
    }
};
$app->before(function (Request $request, Application $app) {
    DomainEventDispatcher::instance()->addListener(UserRegistered::EVENT_NAME, new SendWelcomeEmailOnUserRegistered($app['mailer.service']));
    DomainEventDispatcher::instance()->addListener(UserRegistered::EVENT_NAME, new LogNewUserOnUserRegistered($app['monolog']));
    DomainEventDispatcher::instance()->addListener(TaskWasCreated::EVENT_NAME, new \App\Module\SubModule\Domain\EventListener\SendNoticeEmailOnTaskCreated($app['mailer.service']));
});

