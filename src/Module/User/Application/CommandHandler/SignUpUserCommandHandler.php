<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 18/02/17
 * Time: 0:32
 */

namespace App\Module\SubModule\Application\CommandHandler\User;

use App\Module\SubModule\Application\Command\CommandInterface;
use App\Module\SubModule\Application\Command\User\SignUpUserCommand;
use App\Module\SubModule\Domain\Entity\User\User;
use App\Module\SubModule\Domain\Entity\User\Exception\UserAlreadyExistsException;
use App\Module\SubModule\Domain\ValueObject\User\UserId;
use App\Module\SubModule\Domain\Entity\User\UserRepositoryInterface;
use App\Module\SubModule\Domain\Service\User\PasswordHashingService;
use App\Module\SubModule\Domain\ValueObject\Password\Password;

class SignUpUserCommandHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var PasswordHashingService
     */
    private $hashingService;

    public function __construct(UserRepositoryInterface $userRepository, PasswordHashingService $hashingService)
    {
        $this->userRepository = $userRepository;
        $this->hashingService = $hashingService;
    }

    /**
     * Sign in user in web app
     *
     * @param SignUpUserCommand $userRequest
     * @return bool
     * @throws UserAlreadyExistsException
     */
    public function execute(CommandInterface $userRequest)
    {
        $user = $this->userRepository->fetchByEmail($userRequest->email());
        if (null != $user) {
            throw new UserAlreadyExistsException();
        }
        $user = $this->buildNewUser(
            $userRequest->username(),
            $userRequest->email(),
            Password::fromString($userRequest->password())
        );

        $this->userRepository->add($user);

        return true;
    }

    /**
     * Build new user
     *
     * @param $username
     * @param $email
     * @param $password
     * @codeCoverageIgnore
     *
     * @return User
     */
    protected function buildNewUser($username, $email, $password)
    {
        return new User(
            UserId::generateUserId(),
            $username,
            $email,
            $this->hashingService->hash($password)
        );
    }
}