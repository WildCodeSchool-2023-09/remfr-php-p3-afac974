<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
class Newsletter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'newsletter', targetEntity: News::class)]
    private Collection $news_Id;

    public function __construct()
    {
        $this->news_Id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, News>
     */
    public function getNewsId(): Collection
    {
        return $this->news_Id;
    }

    public function addNewsId(News $newsId): static
    {
        if (!$this->news_Id->contains($newsId)) {
            $this->news_Id->add($newsId);
            $newsId->setNewsletter($this);
        }

        return $this;
    }

    public function removeNewsId(News $newsId): static
    {
        if ($this->news_Id->removeElement($newsId)) {
            // set the owning side to null (unless already changed)
            if ($newsId->getNewsletter() === $this) {
                $newsId->setNewsletter(null);
            }
        }

        return $this;
    }
}
