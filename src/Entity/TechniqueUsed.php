<?php

namespace App\Entity;

use App\Repository\TechniqueUsedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechniqueUsedRepository::class)]
class TechniqueUsed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $technique = null;

    #[ORM\ManyToOne(inversedBy: 'Link_TypeOfWork_Technique')]
    private ?TypeOfWork $Link_TypeOfWork_Technique = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTechnique(): ?string
    {
        return $this->technique;
    }

    public function setTechnique(string $technique): static
    {
        $this->technique = $technique;

        return $this;
    }

    public function getLinkTypeOfWorkTechnique(): ?TypeOfWork
    {
        return $this->Link_TypeOfWork_Technique;
    }

    public function setLinkTypeOfWorkTechnique(?TypeOfWork $Link_TypeOfWork_Technique): static
    {
        $this->Link_TypeOfWork_Technique = $Link_TypeOfWork_Technique;

        return $this;
    }
}
