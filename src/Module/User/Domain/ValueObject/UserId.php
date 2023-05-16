<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 10/02/17
 * Time: 19:29
 */

namespace App\Module\SubModule\Domain\ValueObject\User;

use Ramsey\Uuid\Uuid;

class UserId
{
    /**
     * @var string
     */
    private $id;

    /**
     * UserId constructor.
     */
    private function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    /**
     * Generate user id
     *
     * @return UserId
     */
    public static function generateUserId(): UserId
    {
        return new self();
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
       return $this->id;
    }
}
