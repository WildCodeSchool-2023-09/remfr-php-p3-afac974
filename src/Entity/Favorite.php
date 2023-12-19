<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?User $user_Id = null;

    #[ORM\ManyToOne(inversedBy: 'favorite_Id')]
    private ?Artwork $artwork_Id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_Id;
    }

    public function setUserId(?User $user_Id): static
    {
        $this->user_Id = $user_Id;

        return $this;
    }

    public function getArtworkId(): ?Artwork
    {
        return $this->artwork_Id;
    }

    public function setArtworkId(?Artwork $artwork_Id): static
    {
        $this->artwork_Id = $artwork_Id;

        return $this;
    }
}
