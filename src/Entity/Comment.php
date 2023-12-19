<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Comments = null;

    #[ORM\ManyToOne]
    private ?User $user_Id = null;

    #[ORM\ManyToOne(inversedBy: 'comment_Id')]
    private ?Artwork $artwork_Id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComments(): ?string
    {
        return $this->Comments;
    }

    public function setComments(string $Comments): static
    {
        $this->Comments = $Comments;

        return $this;
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
