<?php

namespace App\Entity;

use App\Repository\PostCardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostCardRepository::class)]
class PostCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Artwork $Link_Artwork_PostCard = null;

    #[ORM\ManyToOne]
    private ?Users $Link_Users_PostCard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinkArtworkPostCard(): ?Artwork
    {
        return $this->Link_Artwork_PostCard;
    }

    public function setLinkArtworkPostCard(?Artwork $Link_Artwork_PostCard): static
    {
        $this->Link_Artwork_PostCard = $Link_Artwork_PostCard;

        return $this;
    }

    public function getLinkUsersPostCard(): ?Users
    {
        return $this->Link_Users_PostCard;
    }

    public function setLinkUsersPostCard(?Users $Link_Users_PostCard): static
    {
        $this->Link_Users_PostCard = $Link_Users_PostCard;

        return $this;
    }
}
