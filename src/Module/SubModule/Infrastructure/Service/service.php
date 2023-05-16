<?php

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use App\Module\SubModule\Application\CommandHandler\CommandHandler;
use App\Module\SubModule\Application\CommandHandler\Task\CreateTaskCommandHandler;
use App\Module\SubModule\Application\CommandHandler\Task\RemoveTaskCommandHandler;
use App\Module\SubModule\Application\CommandHandler\User\SignUpUserCommandHandler;
use App\Module\SubModule\Application\UseCase\User\SignOutUserUseCase;
use App\Module\SubModule\Infrastructure\Service\Mail\Mailer;
use App\Module\SubModule\Presentation\Controllers\Task\CreateTaskController;
use App\Module\SubModule\Presentation\Controllers\Task\ListTaskController;
use App\Module\SubModule\Presentation\Controllers\Task\RemoveTaskController;
use App\Module\SubModule\Presentation\Controllers\User\SignInController;
use App\Module\SubModule\Presentation\Controllers\User\SignOutController;
use Symfony\Component\HttpFoundation\Request;
use App\Module\SubModule\Application\CommandHandler\User\SignInUserCommandHandler;
use App\Module\SubModule\Infrastructure\Service\User\PasswordHashingService;
use App\Module\SubModule\Infrastructure\Service\User\AuthenticateUserService;
use App\Module\SubModule\Presentation\Controllers\User\SignUpController;
use App\Module\Home\Presentation\Controllers\HomeController;

/**
 * Controllers
 */
$app['signin.controller'] = function () use ($app) {
    return new SignInController($app);
};
$app['signup.controller'] = function () use ($app) {
    return new SignUpController($app);
};
$app['home.controller'] = function () use ($app) {
    return new HomeController($app);
};
$app['signout.controller'] = function () use ($app) {
    return new SignOutController($app);
};
$app['createtask.controller'] = function () use ($app) {
    return new CreateTaskController($app);
};
$app['listtask.controller'] = function () use ($app) {
    return new ListTaskController($app);
};
$app['removetask.controller'] = function () use ($app) {
    return new RemoveTaskController($app);
};

/**
 * Services
 */
$app['haspassword.service'] = function () use ($app) {
    return new PasswordHashingService();
};
$app['signin.service'] = function () use ($app) {
    return new SignInUserCommandHandler($app['user_repository'], $app['haspassword.service']);
};
$app['signup.service'] = function () use ($app) {
    return new SignUpUserCommandHandler($app['user_repository'], $app['haspassword.service']);
};
$app['signout.service'] = function () use ($app) {
    return new SignOutUserUseCase($app);
};
$app['commandhandler.service'] = function () use ($app) {
    return new CommandHandler($app);
};
$app['mailer.service'] = function () use ($app) {
    return new Mailer(
        $app['twig']
    );
};
$app['createtask.service'] = function () use ($app) {
    return new CreateTaskCommandHandler($app['user_repository'], $app['task_repository']);
};
$app['removetask.service'] = function () use ($app) {
    return new RemoveTaskCommandHandler($app['task_repository']);
};

/**
 * Repositories
 */
$app['user_repository'] = function () use ($app) {
    return $app['em']->getRepository('App\Module\SubModule\Domain\Entity\User\User');
};
$app['task_repository'] = function () use ($app) {
    return $app['em']->getRepository('App\Module\SubModule\Domain\Entity\Task\Task');
};

