<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 26/02/17
 * Time: 21:03
 */

namespace App\Module\SubModule\Application\CommandHandler;


use App\Module\SubModule\Application\Command\CommandInterface;

interface CommandHandlerInterface
{

    /**
     *
     *
     * @param $command
     * @return mixed
     */
    public function execute(CommandInterface $command);
}
