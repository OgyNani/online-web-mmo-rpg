<?php

namespace App\Entity;

use App\Repository\MobRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MobRepository::class)]
class Mob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $hp = null;

    #[ORM\Column]
    private ?int $defence = null;

    #[ORM\Column]
    private ?int $attack = null;

    #[ORM\Column]
    private ?int $luck = null;

    #[ORM\Column]
    private ?int $speed = null;

    #[ORM\Column]
    private ?int $expDrop = null;

    #[ORM\Column(type: 'json')]
    private array $lootDrop = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;
        return $this;
    }

    public function getDefence(): ?int
    {
        return $this->defence;
    }

    public function setDefence(int $defence): self
    {
        $this->defence = $defence;
        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;
        return $this;
    }

    public function getLuck(): ?int
    {
        return $this->luck;
    }

    public function setLuck(int $luck): self
    {
        $this->luck = $luck;
        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;
        return $this;
    }

    public function getExpDrop(): ?int
    {
        return $this->expDrop;
    }

    public function setExpDrop(int $expDrop): self
    {
        $this->expDrop = $expDrop;
        return $this;
    }

    public function getLootDrop(): array
    {
        return $this->lootDrop;
    }

    public function setLootDrop(array $lootDrop): self
    {
        $this->lootDrop = $lootDrop;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
}
