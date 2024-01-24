<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Technic::class)]
    private Collection $technics;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Artwork::class)]
    private Collection $artworks;

    public function __construct()
    {
        $this->technics = new ArrayCollection();
        $this->artworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Technic>
     */
    public function getTechnics(): Collection
    {
        return $this->technics;
    }

    public function addTechnic(Technic $technic): static
    {
        if (!$this->technics->contains($technic)) {
            $this->technics->add($technic);
            $technic->setType($this);
        }

        return $this;
    }

    public function removeTechnic(Technic $technic): static
    {
        if ($this->technics->removeElement($technic)) {
            // set the owning side to null (unless already changed)
            if ($technic->getType() === $this) {
                $technic->setType(null);
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
            $artwork->setType($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): static
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getType() === $this) {
                $artwork->setType(null);
            }
        }

        return $this;
    }
}
