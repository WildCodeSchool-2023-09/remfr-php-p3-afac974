<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtworkRepository::class)]
class Artwork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $height = null;

    #[ORM\Column]
    private ?int $width = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?bool $isUnique = null;

    #[ORM\Column]
    private ?bool $isSigned = null;

    #[ORM\ManyToOne(inversedBy: 'artwork_Id')]
    private ?Artist $artist_Id = null;

    #[ORM\OneToMany(mappedBy: 'artwork_Id', targetEntity: Favorite::class)]
    private Collection $favorite_Id;

    #[ORM\OneToMany(mappedBy: 'artwork_Id', targetEntity: Comment::class)]
    private Collection $comment_Id;

    #[ORM\ManyToOne(inversedBy: 'artwork_Id')]
    private ?Type $type_Id = null;

    public function __construct()
    {
        $this->favorite_Id = new ArrayCollection();
        $this->comment_Id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function isIsUnique(): ?bool
    {
        return $this->isUnique;
    }

    public function setIsUnique(bool $isUnique): static
    {
        $this->isUnique = $isUnique;

        return $this;
    }

    public function isIsSigned(): ?bool
    {
        return $this->isSigned;
    }

    public function setIsSigned(bool $isSigned): static
    {
        $this->isSigned = $isSigned;

        return $this;
    }

    public function getArtistId(): ?Artist
    {
        return $this->artist_Id;
    }

    public function setArtistId(?Artist $artist_Id): static
    {
        $this->artist_Id = $artist_Id;

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavoriteId(): Collection
    {
        return $this->favorite_Id;
    }

    public function addFavoriteId(Favorite $favoriteId): static
    {
        if (!$this->favorite_Id->contains($favoriteId)) {
            $this->favorite_Id->add($favoriteId);
            $favoriteId->setArtworkId($this);
        }

        return $this;
    }

    public function removeFavoriteId(Favorite $favoriteId): static
    {
        if ($this->favorite_Id->removeElement($favoriteId)) {
            // set the owning side to null (unless already changed)
            if ($favoriteId->getArtworkId() === $this) {
                $favoriteId->setArtworkId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getCommentId(): Collection
    {
        return $this->comment_Id;
    }

    public function addCommentId(Comment $commentId): static
    {
        if (!$this->comment_Id->contains($commentId)) {
            $this->comment_Id->add($commentId);
            $commentId->setArtworkId($this);
        }

        return $this;
    }

    public function removeCommentId(Comment $commentId): static
    {
        if ($this->comment_Id->removeElement($commentId)) {
            // set the owning side to null (unless already changed)
            if ($commentId->getArtworkId() === $this) {
                $commentId->setArtworkId(null);
            }
        }

        return $this;
    }

    public function getTypeId(): ?Type
    {
        return $this->type_Id;
    }

    public function setTypeId(?Type $type_Id): static
    {
        $this->type_Id = $type_Id;

        return $this;
    }
}
