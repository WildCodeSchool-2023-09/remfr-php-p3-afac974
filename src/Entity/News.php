<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $desciption = null;

    #[ORM\Column(length: 255)]
    private ?string $newsImageName = null;
    #[Vich\UploadableField(mapping: 'news', fileNameProperty: 'news')]
    private ?string $newsImagePhoto = null;

    #[ORM\ManyToOne]
    private ?Artist $artistId = null;

    #[ORM\ManyToOne(inversedBy: 'news_Id')]
    private ?Newsletter $newsletter = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDesciption(): ?string
    {
        return $this->desciption;
    }

    public function setDesciption(string $desciption): static
    {
        $this->desciption = $desciption;

        return $this;
    }

    public function getNewsImageName(): ?string
    {
        return $this->newsImageName;
    }

    public function setNewsImageName(string $newsImageName): static
    {
        $this->newsImageName = $newsImageName;

        return $this;
    }
    public function getNewsImagePhoto(): ?string
    {
        return $this->newsImagePhoto;
    }

    public function setNewsImagePhoto(string $newsImagePhoto): static
    {
        $this->newsImagePhoto = $newsImagePhoto;

        return $this;
    }

    public function getArtistId(): ?Artist
    {
        return $this->artistId;
    }

    public function setArtistId(?Artist $artistId): static
    {
        $this->artistId = $artistId;

        return $this;
    }

    public function getNewsletter(): ?Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(?Newsletter $newsletter): static
    {
        $this->newsletter = $newsletter;

        return $this;
    }
}
