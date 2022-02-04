<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setEmail('test' . $i . '@gmail.com');
            $user->setRoles([
                'ROLE_ADMIN',
            ]);

            $password = $this->hasher->hashPassword($user, 'test');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
