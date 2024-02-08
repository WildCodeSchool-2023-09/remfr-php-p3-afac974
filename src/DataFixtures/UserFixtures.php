<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Artwork;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\ArtworkFixtures;
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

    public const ARTIST = [
        ['name' => 'Alice', 'pseudo' => 'AinWonderland', 'lastname' => 'Dupont', 'email' => 'alice@wonderland.com',
        'poster' => 'alice.png', 'description' => 'Alice, jeune artiste émergente en peinture, enchante par sa palette 
        audacieuse et ses œuvres captivantes qui explorent avec ingéniosité la fusion entre l\'émotion humaine et la 
        beauté de la nature. Sa créativité dynamique promet de laisser une empreinte indélébile sur la scène artistique 
        contemporaine.', 'role' => ['ROLE_USER','ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Dan', 'pseudo' => 'DanTheMan', 'lastname' => 'Man', 'email' => 'dan@theman.com',
        'poster' => 'dan.png', 'description' => 'Dan, artiste polymorphe, explore l\'univers créatif avec une maîtrise 
        exceptionnelle de tous les mediums, de la peinture à la sculpture, en passant par la musique et la performance. 
        Sa capacité à transcender les frontières artistiques offre un voyage fascinant à travers la diversité de son 
        expression créative.', 'role' => ['ROLE_USER','ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Edith', 'pseudo' => 'IcantEdith', 'lastname' => 'Piaf', 'email' => 'edith@piaf.com',
        'poster' => 'edith.png', 'description' => 'À 50 ans, Edith, photographe émérite, capture la beauté du monde à 
        travers son objectif, révélant une perspective riche en expérience et en sensibilité. Ses images évoquent une 
        histoire visuelle poignante, fusionnant la maîtrise technique avec une profonde compréhension de la vie.',
        'role' => ['ROLE_USER','ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Elle', 'pseudo' => 'IamElle', 'lastname' => 'Estlà', 'email' => 'elle@there.com',
        'poster' => 'elle.png', 'description' => 'Elle, jeune artiste imprégnée par l\'essence japonaise, fusionne 
        harmonieusement les traditions nippones avec une modernité captivante dans son travail artistique. Ses 
        créations évoquent une élégance délicate et une profonde connexion spirituelle, témoignant de son admiration 
        pour la culture japonaise contemporaine.', 'role' => ['ROLE_USER','ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Lydie', 'pseudo' => 'Lyly', 'lastname' => 'Jolie', 'email' => 'lydie@jolie.com',
        'poster' => 'lydie.png', 'description' => 'Lydie, artiste peintre émergente, révèle son univers créatif à 
        travers des toiles vibrantes où l\'expression spontanée rencontre une palette audacieuse. Son style distinctif 
        et sa capacité à capturer l\'émotion transforment chaque tableau en une expérience visuelle saisissante.',
        'role' => ['ROLE_USER','ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Pedro', 'pseudo' => 'ElPedro', 'lastname' => 'Pasqual', 'email' => 'pedro@pasqual.com',
        'poster' => 'pedro.png', 'description' => 'Pedro, artiste polyvalent, maîtrise l\'art du noir et blanc avec une 
        élégance exceptionnelle. Sa passion pour ce contraste intemporel se manifeste à travers des créations 
        audacieuses, où la simplicité monochrome se transforme en une profonde exploration des nuances et des 
        émotions.', 'role' => ['ROLE_USER','ROLE_ARTIST'], 'password' => 'Pass1*'],

        ['name' => 'Théo', 'pseudo' => 'Théodorus', 'lastname' => 'Dupond', 'email' => 'dupond@dupond.com',
        'poster' => 'theo.png', 'description' => 'Théo, artiste peintre talentueux, insuffle une énergie dynamique à 
        travers ses toiles, capturant l\'essence de la vie avec des coups de pinceau expressifs et une palette de 
        couleurs envoûtante. Son style vibrant et contemporain laisse une empreinte artistique distinctive, suscitant 
        l\'admiration pour sa créativité visionnaire.', 'role' => ['ROLE_USER','ROLE_ARTIST'], 'password' => 'Pass1*'],
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

            $artist = new User();
            $artist->setName($artistName['name']);
            $artist->setPseudonym($artistName['pseudo']);
            $artist->setLastname($artistName['lastname']);
            $artist->setEmail($artistName['email']);
            $artist->setPoster($artistName['poster']);
            $artist->setDescription($artistName['description']);
            $artist->setRoles($artistName['role']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $artist,
                $artistName['password']
            );
            $artist->setPassword($hashedPassword);

            $this->addReference('artist_' . $artistName['name'] . '_' . $artistName['lastname'], $artist);
            $manager->persist($artist);
        }

        $contributor1 = new User();
        $contributor1->setEmail('lauraTyran@monsite.com');
        $contributor1->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor1,
            'lauraTyran1*'
        );
        $contributor1->setPassword($hashedPassword);
        $contributor1->setName('laura');
        $contributor1->setPseudonym('laura');
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
        $contributor2->setPseudonym('anto');
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
        $contributor3->setPseudonym('yannick');
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
        $admin->setPseudonym('admin');
        $admin->setLastName('admin');
        $manager->persist($admin);

        $manager->flush();
    }
}
