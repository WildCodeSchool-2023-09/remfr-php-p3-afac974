<?php

namespace App\Service;

use App\Entity\Artwork;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ArtworkRepository;

class CarousselManager
{
    public function getRandomArtwork(ArtworkRepository $artworkRepository): array
    {
        $allArtworks = $artworkRepository->findAll();

        $randomKeysArtwork = array_rand($allArtworks, 3);

        $randomArtworks = [];

        foreach ($randomKeysArtwork as $key) {
            $randomArtworks[] = $allArtworks[$key];
        }

        return $randomArtworks;
    }

    public function getRandomArtist(UserRepository $userRepository): array
    {
        $allArtists = $userRepository->queryFindAllArtist()->getResult();

        $randomKeysArtist = array_rand($allArtists, 3);

        $randomArtists = [];

        foreach ($randomKeysArtist as $key) {
            $randomArtists[] = $allArtists[$key];
        }

        return $randomArtists;
    }
}
