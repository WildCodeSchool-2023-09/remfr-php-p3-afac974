<?php

namespace App\Entity;

use App\Repository\TechnicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnicRepository::class)]
class Technic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(inversedBy: 'technic_Id', cascade: ['persist', 'remove'])]
    private ?Type $type_Id = null;

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

    public function getTypeId(): ?Type
    {
        return $this->type_Id;
    }

    public function setTypeId(?Type $type_Id): static
    {
        $this->type_Id = $type_Id;

        return $this;
    }
}
