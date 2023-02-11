<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 10/02/17
 * Time: 19:42
 */

namespace App\Module\SubModule\Domain\ValueObject\Email;

class Email
{
    const MAX_LENGTH = 50;
    const MIN_LENGTH = 5;
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     *
     * @param string $email
     */
    private function __construct(string $email)
    {
        $this->setEmail($email);
    }

    /**
     * Named constructor to build an email from string
     *
     * @param string $email
     *
     * @return Email
     */
    public static function fromString(string $email)
    {
        return new self($email);
    }

    /**
     * Get email string.
     *
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * Email setter
     *
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->checkValidEmail($email);
        $this->email = strtolower($email);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->email;
    }

    /**
     * Check if user email is valid
     *
     * @param string $email
     * @throws EmailNotWellFormedException
     */
    private function checkValidEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailNotWellFormedException();
        }
    }
}
