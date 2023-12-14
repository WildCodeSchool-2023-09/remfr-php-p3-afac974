<?php

namespace App\Entity;

use App\Repository\FavoritesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoritesRepository::class)]
class Favorites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Link_Artwork_Comments')]
    private ?Artwork $Link_Artwork_Favorites = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinkArtworkFavorites(): ?Artwork
    {
        return $this->Link_Artwork_Favorites;
    }

    public function setLinkArtworkFavorites(?Artwork $Link_Artwork_Favorites): static
    {
        $this->Link_Artwork_Favorites = $Link_Artwork_Favorites;

        return $this;
    }
}
