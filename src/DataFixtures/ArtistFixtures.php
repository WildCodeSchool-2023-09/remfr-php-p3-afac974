<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Artist;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $artist1 = new Artist();
        $artist1->setName('John');
        $artist1->setLastname('Doe');
        $artist1->setEmail('john.doe@example.com');
        $artist1->setPoster('default_poster_value.svg');
        $artist1->setDescription('Talented artist with a passion for creativity.');
        $artist1->setRoles(['ROLE_ARTIST']);
        $artist1->setPassword('password');
        $manager->persist($artist1);


        $manager->flush();
    }
}
