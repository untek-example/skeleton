<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 18/02/17
 * Time: 20:54
 */

namespace App\Module\SubModule\Domain\EventListener;

use App\Module\SubModule\Domain\Event\DomainEvent;

interface Listener
{
    /**
     * Deal with domain event
     *
     * @param DomainEvent $domainEvent
     *
     * @return mixed
     */
    public function handle(DomainEvent $domainEvent);
}
