<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[Vich\Uploadable]
class Artist extends User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $poster = 'default_poster_value.svg';

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: News::class)]
    private Collection $news;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: Artwork::class)]
    private Collection $artworks;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[Vich\UploadableField(mapping: 'artist_poster', fileNameProperty: 'poster')]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/svg'],
    )]
    private ?File $posterFile = null;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->artworks = new ArrayCollection();
        $this->roles[] = 'ROLE_ARTIST';
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

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster = null): static
    {
        $this->poster = $poster;

        return $this;
    }
    /**
     * @return Collection<int, News>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): static
    {
        if (!$this->news->contains($news)) {
            $this->news->add($news);
            $news->setArtist($this);
        }

        return $this;
    }

    public function removeNews(News $news): static
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getArtist() === $this) {
                $news->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getArtworks(): Collection
    {
        return $this->artworks;
    }

    public function addArtwork(Artwork $artwork): static
    {
        if (!$this->artworks->contains($artwork)) {
            $this->artworks->add($artwork);
            $artwork->setArtist($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): static
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getArtist() === $this) {
                $artwork->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of posterFile
     */
    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    /**
     * Set the value of posterFile
     *
     * @return  self
     */
    public function setPosterFile(File $posterFile = null): Artist
    {
        $this->posterFile = $posterFile;
        if ($posterFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }
    public function getRoles(): array
    {
        $roles = parent::getRoles();

        // Add the specific role for artists
        $roles[] = 'ROLE_ARTIST';

        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return $this->password ?? '';
    }
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        //$this->currentPassword = null;
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
