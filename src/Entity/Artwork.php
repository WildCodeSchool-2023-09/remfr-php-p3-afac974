<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtworkRepository::class)]
class Artwork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Reference = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?int $Height = null;

    #[ORM\Column]
    private ?int $Width = null;

    #[ORM\Column]
    private ?bool $Unique_or_not = null;

    #[ORM\Column]
    private ?bool $Sign_or_not = null;

    #[ORM\OneToMany(mappedBy: 'Link_Artwork_Favorites', targetEntity: Favorites::class)]
    private Collection $Link_Artwork_Comments;

    public function __construct()
    {
        $this->Link_Artwork_Comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->Height;
    }

    public function setHeight(int $Height): static
    {
        $this->Height = $Height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->Width;
    }

    public function setWidth(int $Width): static
    {
        $this->Width = $Width;

        return $this;
    }

    public function isUniqueOrNot(): ?bool
    {
        return $this->Unique_or_not;
    }

    public function setUniqueOrNot(bool $Unique_or_not): static
    {
        $this->Unique_or_not = $Unique_or_not;

        return $this;
    }

    public function isSignOrNot(): ?bool
    {
        return $this->Sign_or_not;
    }

    public function setSignOrNot(bool $Sign_or_not): static
    {
        $this->Sign_or_not = $Sign_or_not;

        return $this;
    }

    /**
     * @return Collection<int, Favorites>
     */
    public function getLinkArtworkComments(): Collection
    {
        return $this->Link_Artwork_Comments;
    }

    public function addLinkArtworkComment(Favorites $linkArtworkComment): static
    {
        if (!$this->Link_Artwork_Comments->contains($linkArtworkComment)) {
            $this->Link_Artwork_Comments->add($linkArtworkComment);
            $linkArtworkComment->setLinkArtworkFavorites($this);
        }

        return $this;
    }

    public function removeLinkArtworkComment(Favorites $linkArtworkComment): static
    {
        if ($this->Link_Artwork_Comments->removeElement($linkArtworkComment)) {
            // set the owning side to null (unless already changed)
            if ($linkArtworkComment->getLinkArtworkFavorites() === $this) {
                $linkArtworkComment->setLinkArtworkFavorites(null);
            }
        }

        return $this;
    }
}
