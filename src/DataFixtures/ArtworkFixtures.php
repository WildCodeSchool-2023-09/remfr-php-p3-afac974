<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artwork;

class ArtworkFixtures extends Fixture
{
    public const ARTWORK = [
        ['is_signed' => false, 'is_unique' => true, 'reference' => 'AB56741', 'title' => 'L\'ours',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
         nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita
         et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
         sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 1999,
         'height' => 110, 'width' => 65, 'artist' => 'Théo Payet', 'picture' => 'bear.png'],

        ['is_signed' => true, 'is_unique' => true, 'reference' => 'AB56742', 'title' => 'L\'homme',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2002,
        'height' => 110, 'width' => 65, 'artist' => 'Théo Payet', 'picture' => 'portrait.png'],

        ['is_signed' => true, 'is_unique' => true, 'reference' => 'AB56743', 'title' => 'L\'oiseau imaginé',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2022,
        'height' => 65, 'width' => 65, 'artist' => 'Hanaé Grondin', 'picture' => 'bird.png'],

        ['is_signed' => false, 'is_unique' => false, 'reference' => 'AB56744', 'title' => 'Forêt brumeuse',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2018,
        'height' => 45, 'width' => 45, 'artist' => 'Maya Riviere', 'picture' => 'forest.png'],

        ['is_signed' => true, 'is_unique' => true, 'reference' => 'AB56745', 'title' => 'Les lunettes d\'Andy',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2005,
        'height' => 110, 'width' => 65, 'artist' => 'Raphaël Damour', 'picture' => 'glasses.png'],

        ['is_signed' => true, 'is_unique' => true, 'reference' => 'AB56746', 'title' => 'Paysage Onirique',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2017,
        'height' => 110, 'width' => 65, 'artist' => 'Hanaé Grondin', 'picture' => 'cherry-blossom.png'],
    ];

    public function load(ObjectManager $manager): void
    {
        $uploadArtworkDir = '/uploads/artwork';

        if (!is_dir(__DIR__ . '/../../public' . $uploadArtworkDir)) {
            mkdir(__DIR__ . '/../../public' . $uploadArtworkDir, recursive: true);
        }

        foreach (self::ARTWORK as $artworkName) {
            copy(
                __DIR__ . '/data/artwork/' . $artworkName['picture'],
                __DIR__ . '/../../public' . $uploadArtworkDir . '/' . $artworkName['picture']
            );

            $artwork = new Artwork();
            $artwork->setReference($artworkName['reference']);
            $artwork->setIsSigned($artworkName['is_signed']);
            $artwork->setIsUnique($artworkName['is_unique']);
            $artwork->setTitle($artworkName['title']);
            $artwork->setDescription($artworkName['description']);
            $artwork->setYear($artworkName['year']);
            $artwork->setHeight($artworkName['height']);
            $artwork->setWidth($artworkName['width']);
            //$artwork->setArtist($artworkName['artist']);
            $artwork->setPicture($artworkName['picture']);

            $manager->persist($artwork);
        }
        $manager->flush();
    }
}
