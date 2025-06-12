<?php

namespace App\Entity;

use App\Repository\CharacterClassRepository;
use App\Entity\ClassBaseStats;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterClassRepository::class)]
#[ORM\Table(name: '`character_class`')]
class CharacterClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $name = null;

    #[ORM\OneToOne(targetEntity: ClassBaseStats::class, mappedBy: 'characterClass')]
    private ?ClassBaseStats $stats = null;

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

    public function getStats(): ?ClassBaseStats
    {
        return $this->stats;
    }

    public function setStats(?ClassBaseStats $stats): static
    {
        $this->stats = $stats;
        return $this;
    }
}
