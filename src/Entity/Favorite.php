<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'favorites')]
    private Collection $Users;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Artwork $artwork = null;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->Users->contains($user)) {
            $this->Users->add($user);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        $this->Users->removeElement($user);

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
