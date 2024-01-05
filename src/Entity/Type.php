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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Artwork $artwork = null;

    public function __construct()
    {
        $this->technics = new ArrayCollection();
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

    public function getArtwork(): ?Artwork
    {
        return $this->artwork;
    }

    public function setArtwork(?Artwork $artwork): static
    {
        $this->artwork = $artwork;

        return $this;
    }
}
