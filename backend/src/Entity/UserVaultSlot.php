<?php

namespace App\Entity;

use App\Repository\UserVaultSlotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserVaultSlotRepository::class)]
class UserVaultSlot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'slots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserVault $vault = null;

    #[ORM\ManyToOne]
    private ?Item $item = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $itemCustomId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVault(): ?UserVault
    {
        return $this->vault;
    }

    public function setVault(?UserVault $vault): self
    {
        $this->vault = $vault;
        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;
        return $this;
    }

    public function getItemCustomId(): ?string
    {
        return $this->itemCustomId;
    }

    public function setItemCustomId(?string $itemCustomId): self
    {
        $this->itemCustomId = $itemCustomId;
        return $this;
    }
}
