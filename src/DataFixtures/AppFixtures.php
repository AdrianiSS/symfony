<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {

    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('test@test.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                'password'
            )
        );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('test2@test.com');
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                'password2'
            )
        );
        $manager->persist($user2);

        $microPost1 = new MicroPost();
        $microPost1->setTitle('Welcome to Slovakia');
        $microPost1->setText('Welcome to Slovakia');
        $microPost1->setCreated(new \DateTime());
        $microPost1->setAuthor($user1);
        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle('Welcome to Czechoslovakia');
        $microPost2->setText('Welcome to Czechoslovakia');
        $microPost2->setCreated(new \DateTime());
        $microPost2->setAuthor($user2);
        $manager->persist($microPost2);

        $microPost3 = new MicroPost();
        $microPost3->setTitle('Welcome to Poland');
        $microPost3->setText('Welcome to Poland');
        $microPost3->setCreated(new \DateTime());
        $microPost3->setAuthor($user1);
        $manager->persist($microPost3);

        $manager->flush();
    }
}
