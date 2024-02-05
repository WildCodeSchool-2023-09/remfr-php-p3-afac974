<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artwork;
use App\Entity\User;

class ArtworkFixtures extends Fixture implements DependentFixtureInterface
{
    public const ARTWORK = [
        ['is_signed' => false, 'is_unique' => true, 'title' => 'L\'ours', 'type' => 'type_Sculpture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
         nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita
         et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
         sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 1999,
         'height' => 110, 'width' => 65, 'artist' => 'artist_Dan_Man', 'picture' => 'bear.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'L\'homme', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2002,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Pedro_Pasqual', 'picture' => 'portrait.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'L\'oiseau imaginé', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2022,
        'height' => 65, 'width' => 65, 'artist' => 'artist_Alice_Dupont', 'picture' => 'bird.png'],

        ['is_signed' => false, 'is_unique' => false, 'title' => 'Forêt brumeuse', 'type' => 'type_Photographie',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2018,
        'height' => 45, 'width' => 45, 'artist' => 'artist_Edith_Piaf', 'picture' => 'forest.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Les lunettes d\'Andy', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2005,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Dan_Man', 'picture' => 'glasses.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Paysage Onirique', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2017,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Théo_Dupond', 'picture' => 'cherry-blossom.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Plage de Martinique', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2000,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Théo_Dupond', 'picture' => 'beach.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'La Femme solaire', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2023,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Lydie_Jolie', 'picture' => 'black_woman.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Eglise au matin', 'type' => 'type_Photographie',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2010,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Pedro_Pasqual', 'picture' => 'church.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Habitant du récif', 'type' => 'type_Photographie',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2017,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Edith_Piaf', 'picture' => 'fish.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Geisha', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2009,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Elle_Estlà', 'picture' => 'geisha.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Orange Anime', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2014,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Elle_Estlà', 'picture' => 'japan.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Nature morte', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 1998,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Lydie_Jolie', 'picture' => 'orange.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Le Python', 'type' => 'type_Photographie',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2021,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Edith_Piaf', 'picture' => 'volcano.png'],

        ['is_signed' => true, 'is_unique' => true, 'title' => 'Aquarelle marbrée', 'type' => 'type_Peinture',
        'description' => 'Lorem ipsum dolor sit amet. Et dicta placeat aut deserunt vero At enim ullam ab repellat 
        nihil et enim possimus est voluptatem officia vel delectus excepturi. Id sunt doloremque aut alias expedita 
        et expedita consequatur. Id voluptatibus temporibus id saepe nobis et nobis deserunt. Aut quas eveniet ut 
        sapiente fugiat eum doloremque dolorem rem pariatur iste qui omnis earum.', 'year' => 2024,
        'height' => 110, 'width' => 65, 'artist' => 'artist_Alice_Dupont', 'picture' => 'watercolor.png'],
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
            $artwork->setIsSigned($artworkName['is_signed']);
            $artwork->setIsUnique($artworkName['is_unique']);
            $artwork->setTitle($artworkName['title']);
            $artwork->setDescription($artworkName['description']);
            $artwork->setYear($artworkName['year']);
            $artwork->setHeight($artworkName['height']);
            $artwork->setWidth($artworkName['width']);

            $artist = $this->getReference($artworkName['artist']);
            $artwork->setUser($artist);
            $artist->addArtwork($artwork);
            $artwork->setType($this->getReference($artworkName['type']));
            $artwork->setPicture($artworkName['picture']);

            $manager->persist($artwork);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          UserFixtures::class,
          TypeFixtures::class,
        ];
    }
}
