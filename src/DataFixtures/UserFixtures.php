<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $contributor1 = new User();
        $contributor1->setEmail('lauraTyran@monsite.com');
        $contributor1->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor1,
            'lauraTyran1*'
        );
        $contributor1->setPassword($hashedPassword);
        $contributor1->setName('laura');
        $contributor1->setLastName('wolf');
        $manager->persist($contributor1);


        $contributor2 = new User();
        $contributor2->setEmail('antoninBg@monsite.com');
        $contributor2->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor2,
            'antoninBg1*'
        );
        $contributor2->setPassword($hashedPassword);
        $contributor2->setName('antonin');
        $contributor2->setLastName('brodel');
        $manager->persist($contributor2);


        $contributor3 = new User();
        $contributor3->setEmail('yannickCafe@monsite.com');
        $contributor3->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor3,
            'yannickCafe1*'
        );
        $contributor3->setPassword($hashedPassword);
        $contributor3->setName('yannick');
        $contributor3->setLastName('ledoux');
        $manager->persist($contributor3);


        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'Adminpassword1*'
        );
        $admin->setPassword($hashedPassword);
        $admin->setName('admin');
        $admin->setLastName('admin');
        $manager->persist($admin);

        $manager->flush();
    }
}
