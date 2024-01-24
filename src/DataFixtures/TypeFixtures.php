<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Type;

class TypeFixtures extends Fixture
{
    public const TYPE = [
        ['name' => 'Peinture'],
        ['name' => 'Sculpture'],
        ['name' => 'Photographie']
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TYPE as $typeName) {
            $type = new TYPE();
            $type->setName($typeName['name']);

            $this->addReference('type_' . $typeName['name'], $type);
            $manager->persist($type);
        }
        $manager->flush();
    }
}
