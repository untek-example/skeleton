<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 11/02/17
 * Time: 0:27
 */

namespace App\Module\SubModule\Presentation\Controllers\User;

use App\Module\SubModule\Application\Command\User\SignInUserCommand;
use Silex\Application;
use App\Module\SubModule\Domain\Entity\User\Exception\UserPasswordDoesNotMatchException;
use App\Module\SubModule\Infrastructure\Service\User\AuthenticateUserService;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SignInController
{
    /**
     * @var Application
     */
    private $application;

    /**
     * SignInController constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @return mixed
     */
    public function indexAction()
    {
        /** @var Form $form */
        $form = $this->application['sign_in_form'];
        $form->handleRequest($this->application['request_stack']->getCurrentRequest());

        try {
            if ($form->isValid()) {
                $user = $this->application['commandhandler.service']->execute(
                    new SignInUserCommand(
                        $form->get('email')->getData(),
                        $form->get('password')->getData()
                    )
                );
                if (null != $user) {
                    (new AuthenticateUserService($this->application['session']))->authenticate($user);
                    return $this->application->redirect($this->application['url_generator']->generate('home'));
                }
            }
        } catch (UserPasswordDoesNotMatchException $passwordDoesNotMatchException) {
            $form->get('password')->addError(new FormError('Password does not match'));
        }

        return $this->application['twig']->render('views/user/login.html.twig',
            [
                'form' => $this->application['sign_in_form']->createView()
            ]
        );
    }
}