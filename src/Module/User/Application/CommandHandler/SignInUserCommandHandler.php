<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 12/02/17
 * Time: 13:14
 */

namespace App\Module\SubModule\Application\CommandHandler\User;

use App\Module\SubModule\Application\Command\User\SignInUserCommand;
use App\Module\SubModule\Domain\Entity\User\User;
use App\Module\SubModule\Domain\Entity\User\Exception\UserDoesNotExistsException;
use App\Module\SubModule\Domain\Entity\User\Exception\UserPasswordDoesNotMatchException;
use App\Module\SubModule\Domain\Entity\User\UserRepositoryInterface;
use App\Module\SubModule\Domain\Service\User\PasswordHashingService;
use App\Module\SubModule\Domain\Service\User\UserAuthentifierService;
use Symfony\Component\Config\Definition\Exception\Exception;

class SignInUserCommandHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var PasswordHashingService
     */
    private $hashingService;


    /**
     * SignInUserCommandHandler constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param PasswordHashingService $hashingService
     */
    public function __construct(UserRepositoryInterface $userRepository, PasswordHashingService $hashingService)
    {
        $this->userRepository = $userRepository;
        $this->hashingService = $hashingService;
    }

    /**
     * Sign in user in web app
     *
     * @param SignInUserCommand $userRequest
     * @return User
     * @throws UserDoesNotExistsException
     * @throws UserPasswordDoesNotMatchException
     */
    public function execute(SignInUserCommand $userRequest): User
    {
        /** @var User $user */
        $user = $this->userRepository->fetchByEmail($userRequest->email());
        if (null == $user) {
            throw new UserDoesNotExistsException();
        }
        $isVerified = $this->hashingService->verifyPassword($user->password(), $userRequest->password());
        if (!$isVerified) {
            throw new UserPasswordDoesNotMatchException();
        }

        return $user;
    }
}
