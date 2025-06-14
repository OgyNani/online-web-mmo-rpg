<?php

namespace App\Entity;

use App\Repository\CharacterInventoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterInventoryRepository::class)]
class CharacterInventory
{
    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserCharacter $character = null;

    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $itemCustomId = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    public function getCharacter(): ?UserCharacter
    {
        return $this->character;
    }

    public function setCharacter(?UserCharacter $character): self
    {
        $this->character = $character;
        return $this;
    }

    public function getItemCustomId(): ?string
    {
        return $this->itemCustomId;
    }

    public function setItemCustomId(string $itemCustomId): self
    {
        $this->itemCustomId = $itemCustomId;
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
}
