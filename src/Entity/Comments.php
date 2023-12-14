<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Comment = null;

    #[ORM\ManyToOne]
    private ?Users $Link_Users_Comments = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artwork $Link_Artwork_Comments = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(string $Comment): static
    {
        $this->Comment = $Comment;

        return $this;
    }

    public function getLinkUsersComments(): ?Users
    {
        return $this->Link_Users_Comments;
    }

    public function setLinkUsersComments(?Users $Link_Users_Comments): static
    {
        $this->Link_Users_Comments = $Link_Users_Comments;

        return $this;
    }

    public function getLinkArtworkComments(): ?Artwork
    {
        return $this->Link_Artwork_Comments;
    }

    public function setLinkArtworkComments(?Artwork $Link_Artwork_Comments): static
    {
        $this->Link_Artwork_Comments = $Link_Artwork_Comments;

        return $this;
    }
}
