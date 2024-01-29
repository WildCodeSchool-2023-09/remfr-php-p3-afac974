<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Artist;

class ArtistFixtures extends Fixture
{
    public const ARTIST = [
        ['name' => 'Alice', 'pseudo' => 'AinWonderland', 'lastname' => 'Dupont', 'email' => 'alice@wonderland.com',
        'poster' => 'alice.png', 'description' => 'Alice, jeune artiste émergente en peinture, enchante par sa palette 
        audacieuse et ses œuvres captivantes qui explorent avec ingéniosité la fusion entre l\'émotion humaine et la 
        beauté de la nature. Sa créativité dynamique promet de laisser une empreinte indélébile sur la scène artistique 
        contemporaine.', 'role' => ['ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Dan', 'pseudo' => 'DanTheMan', 'lastname' => 'Man', 'email' => 'dan@theman.com',
        'poster' => 'dan.png', 'description' => 'Dan, artiste polymorphe, explore l\'univers créatif avec une maîtrise 
        exceptionnelle de tous les mediums, de la peinture à la sculpture, en passant par la musique et la performance. 
        Sa capacité à transcender les frontières artistiques offre un voyage fascinant à travers la diversité de son 
        expression créative.', 'role' => ['ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Edith', 'pseudo' => 'IcantEdith', 'lastname' => 'Piaf', 'email' => 'edith@piaf.com',
        'poster' => 'edith.png', 'description' => 'À 50 ans, Edith, photographe émérite, capture la beauté du monde à 
        travers son objectif, révélant une perspective riche en expérience et en sensibilité. Ses images évoquent une 
        histoire visuelle poignante, fusionnant la maîtrise technique avec une profonde compréhension de la vie.',
        'role' => ['ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Elle', 'pseudo' => 'IamElle', 'lastname' => 'Estlà', 'email' => 'elle@there.com',
        'poster' => 'elle.png', 'description' => 'Elle, jeune artiste imprégnée par l\'essence japonaise, fusionne 
        harmonieusement les traditions nippones avec une modernité captivante dans son travail artistique. Ses 
        créations évoquent une élégance délicate et une profonde connexion spirituelle, témoignant de son admiration 
        pour la culture japonaise contemporaine.', 'role' => ['ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Lydie', 'pseudo' => 'Lyly', 'lastname' => 'Jolie', 'email' => 'lydie@jolie.com',
        'poster' => 'lydie.png', 'description' => 'Lydie, artiste peintre émergente, révèle son univers créatif à 
        travers des toiles vibrantes où l\'expression spontanée rencontre une palette audacieuse. Son style distinctif 
        et sa capacité à capturer l\'émotion transforment chaque tableau en une expérience visuelle saisissante.',
        'role' => ['ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Pedro', 'pseudo' => 'ElPedro', 'lastname' => 'Pasqual', 'email' => 'pedro@pasqual.com',
        'poster' => 'pedro.png', 'description' => 'Pedro, artiste polyvalent, maîtrise l\'art du noir et blanc avec une 
        élégance exceptionnelle. Sa passion pour ce contraste intemporel se manifeste à travers des créations 
        audacieuses, où la simplicité monochrome se transforme en une profonde exploration des nuances et des 
        émotions.', 'role' => ['ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Théo', 'pseudo' => 'Théodorus', 'lastname' => 'Dupond', 'email' => 'dupond@dupond.com',
        'poster' => 'theo.png', 'description' => 'Théo, artiste peintre talentueux, insuffle une énergie dynamique à 
        travers ses toiles, capturant l\'essence de la vie avec des coups de pinceau expressifs et une palette de 
        couleurs envoûtante. Son style vibrant et contemporain laisse une empreinte artistique distinctive, suscitant 
        l\'admiration pour sa créativité visionnaire.', 'role' => ['ROLE_ARTIST'], 'password' => 'Pass1*'],
    ];

    public function load(ObjectManager $manager): void
    {
        $uploadArtistDir = '/uploads/artistPhoto';

        if (!is_dir(__DIR__ . '/../../public' . $uploadArtistDir)) {
            mkdir(__DIR__ . '/../../public' . $uploadArtistDir, recursive: true);
        }

        foreach (self::ARTIST as $artistName) {
            copy(
                __DIR__ . '/data/artistPhoto/' . $artistName['poster'],
                __DIR__ . '/../../public' . $uploadArtistDir . '/' . $artistName['poster']
            );

            $artist = new Artist();
            $artist->setName($artistName['name']);
            $artist->setPseudonym($artistName['pseudo']);
            $artist->setLastname($artistName['lastname']);
            $artist->setEmail($artistName['email']);
            $artist->setPoster($artistName['poster']);
            $artist->setDescription($artistName['description']);
            $artist->setRoles($artistName['role']);
            $artist->setPassword($artistName['password']);

            $this->addReference('artist_' . $artistName['name'] . '_' . $artistName['lastname'], $artist);
            $manager->persist($artist);


            $manager->flush();
        }
    }
}
