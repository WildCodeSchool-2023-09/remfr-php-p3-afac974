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

    #[ORM\OneToMany(mappedBy: 'type_Id', targetEntity: Artwork::class)]
    private Collection $artwork_Id;

    #[ORM\OneToOne(mappedBy: 'type_Id', cascade: ['persist', 'remove'])]
    private ?Technic $technic_Id = null;

    public function __construct()
    {
        $this->artwork_Id = new ArrayCollection();
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
            $artworkId->setTypeId($this);
        }

        return $this;
    }

    public function removeArtworkId(Artwork $artworkId): static
    {
        if ($this->artwork_Id->removeElement($artworkId)) {
            // set the owning side to null (unless already changed)
            if ($artworkId->getTypeId() === $this) {
                $artworkId->setTypeId(null);
            }
        }

        return $this;
    }

    public function getTechnicId(): ?Technic
    {
        return $this->technic_Id;
    }

    public function setTechnicId(?Technic $technic_Id): static
    {
        // unset the owning side of the relation if necessary
        if ($technic_Id === null && $this->technic_Id !== null) {
            $this->technic_Id->setTypeId(null);
        }

        // set the owning side of the relation if necessary
        if ($technic_Id !== null && $technic_Id->getTypeId() !== $this) {
            $technic_Id->setTypeId($this);
        }

        $this->technic_Id = $technic_Id;

        return $this;
    }
}
