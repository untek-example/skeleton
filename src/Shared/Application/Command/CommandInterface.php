<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 26/02/17
 * Time: 21:06
 */

namespace App\Module\SubModule\Application\Command;


interface CommandInterface
{

    /**
     * @return string
     */
    public function commandHandler(): string;
}
