<?php

namespace App\Entity;

use App\Repository\PostcardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostcardRepository::class)]
class Postcard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'postcards_Id')]
    private Collection $user_Id;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Artwork $Artwork_Id = null;

    public function __construct()
    {
        $this->user_Id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->user_Id;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->user_Id->contains($userId)) {
            $this->user_Id->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        $this->user_Id->removeElement($userId);

        return $this;
    }

    public function getArtworkId(): ?Artwork
    {
        return $this->Artwork_Id;
    }

    public function setArtworkId(?Artwork $Artwork_Id): static
    {
        $this->Artwork_Id = $Artwork_Id;

        return $this;
    }
}
