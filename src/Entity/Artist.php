<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[Vich\Uploadable]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $photoName = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $userId = null;
    private ?File $artistPhoto = null;

    #[ORM\OneToMany(mappedBy: 'artist_Id', targetEntity: Artwork::class)]
    private Collection $artwork_Id;

    public function __construct()
    {
        $this->artwork_Id = new ArrayCollection();
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

    public function getPhotoName(): ?string
    {
        return $this->photoName;
    }

    public function setPhotoName(string $photoName): static
    {
        $this->photoName = $photoName;

        return $this;
    }
    #[Vich\UploadableField(mapping: 'artistPhoto', fileNameProperty: 'artistPhoto')]
    public function getArtistPhoto(): ?string
    {
        return $this->photoName;
    }

    public function setArtistPhoto(string $photoName): static
    {
        $this->photoName = $photoName;
        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getArtworkId(): Collection
    {
        return $this->artwork_Id;
    }

    public function addArtworkId(Artwork $artworkId): static
    {
        if (!$this->artwork_Id->contains($artworkId)) {
            $this->artwork_Id->add($artworkId);
            $artworkId->setArtistId($this);
        }

        return $this;
    }

    public function removeArtworkId(Artwork $artworkId): static
    {
        if ($this->artwork_Id->removeElement($artworkId)) {
            // set the owning side to null (unless already changed)
            if ($artworkId->getArtistId() === $this) {
                $artworkId->setArtistId(null);
            }
        }

        return $this;
    }
}
