<?php

namespace App\Entity;

use App\Repository\CharacterEquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterEquipmentRepository::class)]
class CharacterEquipment
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'equipment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserCharacter $character = null;

    #[ORM\ManyToOne]
    private ?Item $hat = null;

    #[ORM\ManyToOne]
    private ?Item $armor = null;

    #[ORM\ManyToOne]
    private ?Item $pants = null;

    #[ORM\ManyToOne]
    private ?Item $shoes = null;

    #[ORM\ManyToOne]
    private ?Item $weapon = null;

    #[ORM\ManyToOne]
    private ?Item $ability = null;

    #[ORM\ManyToOne]
    private ?Item $ring = null;

    public function getCharacter(): ?UserCharacter
    {
        return $this->character;
    }

    public function setCharacter(UserCharacter $character): self
    {
        $this->character = $character;
        return $this;
    }

    public function getHat(): ?Item
    {
        return $this->hat;
    }

    public function setHat(?Item $hat): self
    {
        $this->hat = $hat;
        return $this;
    }

    public function getArmor(): ?Item
    {
        return $this->armor;
    }

    public function setArmor(?Item $armor): self
    {
        $this->armor = $armor;
        return $this;
    }

    public function getPants(): ?Item
    {
        return $this->pants;
    }

    public function setPants(?Item $pants): self
    {
        $this->pants = $pants;
        return $this;
    }

    public function getShoes(): ?Item
    {
        return $this->shoes;
    }

    public function setShoes(?Item $shoes): self
    {
        $this->shoes = $shoes;
        return $this;
    }

    public function getWeapon(): ?Item
    {
        return $this->weapon;
    }

    public function setWeapon(?Item $weapon): self
    {
        $this->weapon = $weapon;
        return $this;
    }

    public function getAbility(): ?Item
    {
        return $this->ability;
    }

    public function setAbility(?Item $ability): self
    {
        $this->ability = $ability;
        return $this;
    }

    public function getRing(): ?Item
    {
        return $this->ring;
    }

    public function setRing(?Item $ring): self
    {
        $this->ring = $ring;
        return $this;
    }
}
