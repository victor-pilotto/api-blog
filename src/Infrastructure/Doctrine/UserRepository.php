<?php

namespace App\Infrastructure\Doctrine;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManager;
use App\Domain\Exception;

class UserRepository implements UserRepositoryInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function store(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function getById(UserId $id): User
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if ($user instanceof User) {
            return $user;
        }

        throw Exception\UserNaoExisteException::execute();
    }

    public function findByEmail(Email $email): ?User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        return $user instanceof User ? $user : null;
    }

    public function findByEmailAndPassword(Email $email, Password $password): ?User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email'    => $email,
            'password' => $password,
        ]);

        return $user instanceof User ? $user : null;
    }



}
