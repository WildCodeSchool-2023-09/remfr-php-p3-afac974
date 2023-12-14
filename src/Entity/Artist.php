<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?int $Immatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $Photo = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Users $Link_Users_Artist = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImmatriculation(): ?int
    {
        return $this->Immatriculation;
    }

    public function setImmatriculation(int $Immatriculation): static
    {
        $this->Immatriculation = $Immatriculation;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(string $Photo): static
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getLinkUsersArtist(): ?Users
    {
        return $this->Link_Users_Artist;
    }

    public function setLinkUsersArtist(?Users $Link_Users_Artist): static
    {
        $this->Link_Users_Artist = $Link_Users_Artist;

        return $this;
    }
}
