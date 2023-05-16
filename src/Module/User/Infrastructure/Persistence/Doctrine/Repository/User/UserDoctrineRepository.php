<?php
/**
 * Created by PhpStorm.
 * User: dtome
 * Date: 17/02/17
 * Time: 20:05
 */

namespace App\Module\SubModule\Infrastructure\Persistence\Doctrine\Repository\User;

use Doctrine\ORM\EntityRepository;
use App\Module\SubModule\Domain\Entity\User\User;
use App\Module\SubModule\Domain\Entity\User\UserRepositoryInterface;
use App\Module\SubModule\Infrastructure\Persistence\Doctrine\Repository\AbstractEntityRepository;

class UserDoctrineRepository extends AbstractEntityRepository implements UserRepositoryInterface
{
    /**
     * @param User $user
     * @return mixed|void
     */
    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param $email
     *
     * @return array
     */
    public function fetchByEmail($email)
    {
        return $this->getEntityManager()->getRepository(User::class)->findOneBy(['email.email' => $email]);
    }
}
