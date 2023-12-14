<?php

namespace App\Entity;

use App\Repository\TypeOfWorkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeOfWorkRepository::class)]
class TypeOfWork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\OneToMany(mappedBy: 'Link_TypeOfWork_Technique', targetEntity: TechniqueUsed::class)]
    private Collection $Link_TypeOfWork_Technique;

    public function __construct()
    {
        $this->Link_TypeOfWork_Technique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return Collection<int, TechniqueUsed>
     */
    public function getLinkTypeOfWorkTechnique(): Collection
    {
        return $this->Link_TypeOfWork_Technique;
    }

    public function addLinkTypeOfWorkTechnique(TechniqueUsed $linkTypeOfWorkTechnique): static
    {
        if (!$this->Link_TypeOfWork_Technique->contains($linkTypeOfWorkTechnique)) {
            $this->Link_TypeOfWork_Technique->add($linkTypeOfWorkTechnique);
            $linkTypeOfWorkTechnique->setLinkTypeOfWorkTechnique($this);
        }

        return $this;
    }

    public function removeLinkTypeOfWorkTechnique(TechniqueUsed $linkTypeOfWorkTechnique): static
    {
        if ($this->Link_TypeOfWork_Technique->removeElement($linkTypeOfWorkTechnique)) {
            // set the owning side to null (unless already changed)
            if ($linkTypeOfWorkTechnique->getLinkTypeOfWorkTechnique() === $this) {
                $linkTypeOfWorkTechnique->setLinkTypeOfWorkTechnique(null);
            }
        }

        return $this;
    }
}
