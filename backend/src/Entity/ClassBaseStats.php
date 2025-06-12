<?php

namespace App\Entity;

use App\Repository\ClassBaseStatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassBaseStatsRepository::class)]
#[ORM\Table(name: 'class_base_stats')]
class ClassBaseStats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: CharacterClass::class, inversedBy: 'stats')]
    #[ORM\JoinColumn(name: 'character_id', referencedColumnName: 'id', nullable: false)]
    private ?CharacterClass $characterClass = null;

    #[ORM\Column]
    private int $rawHp;

    #[ORM\Column]
    private int $rawDefence;

    #[ORM\Column]
    private int $rawAttack;

    #[ORM\Column]
    private int $rawLuck;

    #[ORM\Column]
    private int $maxRawHp;

    #[ORM\Column]
    private int $maxRawDefence;

    #[ORM\Column]
    private int $maxRawAttack;

    #[ORM\Column]
    private int $maxRawLuck;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacterClass(): ?CharacterClass
    {
        return $this->characterClass;
    }

    public function setCharacterClass(CharacterClass $characterClass): self
    {
        $this->characterClass = $characterClass;
        return $this;
    }

    public function getRawHp(): int
    {
        return $this->rawHp;
    }

    public function setRawHp(int $rawHp): self
    {
        $this->rawHp = $rawHp;
        return $this;
    }

    public function getRawDefence(): int
    {
        return $this->rawDefence;
    }

    public function setRawDefence(int $rawDefence): self
    {
        $this->rawDefence = $rawDefence;
        return $this;
    }

    public function getRawAttack(): int
    {
        return $this->rawAttack;
    }

    public function setRawAttack(int $rawAttack): self
    {
        $this->rawAttack = $rawAttack;
        return $this;
    }

    public function getRawLuck(): int
    {
        return $this->rawLuck;
    }

    public function setRawLuck(int $rawLuck): self
    {
        $this->rawLuck = $rawLuck;
        return $this;
    }

    public function getMaxRawHp(): int
    {
        return $this->maxRawHp;
    }

    public function setMaxRawHp(int $maxRawHp): self
    {
        $this->maxRawHp = $maxRawHp;
        return $this;
    }

    public function getMaxRawDefence(): int
    {
        return $this->maxRawDefence;
    }

    public function setMaxRawDefence(int $maxRawDefence): self
    {
        $this->maxRawDefence = $maxRawDefence;
        return $this;
    }

    public function getMaxRawAttack(): int
    {
        return $this->maxRawAttack;
    }

    public function setMaxRawAttack(int $maxRawAttack): self
    {
        $this->maxRawAttack = $maxRawAttack;
        return $this;
    }

    public function getMaxRawLuck(): int
    {
        return $this->maxRawLuck;
    }

    public function setMaxRawLuck(int $maxRawLuck): self
    {
        $this->maxRawLuck = $maxRawLuck;
        return $this;
    }
}
