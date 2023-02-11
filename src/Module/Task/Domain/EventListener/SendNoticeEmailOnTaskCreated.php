<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 15/03/17
 * Time: 12:56
 */

namespace App\Module\SubModule\Domain\EventListener;

use App\Module\SubModule\Application\EmailTemplate\User\TaskCreatedUserEmail;
use App\Module\SubModule\Domain\Event\DomainEvent;
use App\Module\SubModule\Domain\Event\Task\TaskWasCreated;
use App\Module\SubModule\Infrastructure\Service\Mail\Mailer;

class SendNoticeEmailOnTaskCreated implements Listener
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * SendWelcomeEmailOnUserRegistered constructor.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Deal with domain event
     *
     * @param DomainEvent $domainEvent
     *
     * @return mixed
     */
    public function handle(DomainEvent $domainEvent)
    {
        $this->mailer->send(
            new TaskCreatedUserEmail(
                $domainEvent->taskTitle(),
                $domainEvent->taskDescription(),
                $domainEvent->userAssigned()
            )
        );
    }
}