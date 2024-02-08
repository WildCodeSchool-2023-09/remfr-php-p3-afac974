<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTime;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: ArtworkRepository::class)]
#[Vich\Uploadable]
#[Assert\EnableAutoMapping]
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
    #[Assert\Positive(
        message: 'La valeur doit être positive'
    )]
    private ?int $height = null;

    #[ORM\Column]
    #[Assert\Positive(
        message: 'La valeur doit être positive'
    )]
    private ?int $width = null;

    #[ORM\Column]
    private ?bool $isUnique = null;

    #[ORM\Column]
    private ?bool $isSigned = null;

    #[ORM\ManyToOne(inversedBy: 'artworks')]
    #[ORM\JoinColumn(
        name:"user_id",
        referencedColumnName: "id",
        onDelete: "SET NULL"
    )]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'artwork', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[Vich\UploadableField(mapping: 'artwork', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $pictureFile = null;

    #[ORM\Column]
    private ?int $year = null;
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favorites')]
    private Collection $favoritedBy;

    #[ORM\ManyToOne(inversedBy: 'artworks')]
    private ?Type $type = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->favoritedBy = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
    public function removeUser(): void
    {
        if ($this->user !== null) {
            $this->user->removeArtwork($this);
            $this->user = null;
        }
    }
    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setArtwork($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArtwork() === $this) {
                $comment->setArtwork(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function setPictureFile(File $pictureFile = null): Artwork
    {
        $this->pictureFile = $pictureFile;
        if ($pictureFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }


    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoritedBy(): Collection
    {
        return $this->favoritedBy;
    }

    public function addFavoritedBy(User $favoritedBy): static
    {
        if (!$this->favoritedBy->contains($favoritedBy)) {
            $this->favoritedBy->add($favoritedBy);
        }

        return $this;
    }

    public function removeFavoritedBy(User $favoritedBy): static
    {
        $this->favoritedBy->removeElement($favoritedBy);

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function removeType(Type $type): self
    {
        // set the owning side to null (unless already changed)
        if ($this->type === $type) {
            $this->type = null;
        }

        return $this;
    }
}
