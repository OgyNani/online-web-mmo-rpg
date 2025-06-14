<?php

namespace App\Entity;

use App\Repository\UserVaultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserVaultRepository::class)]
class UserVault
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'vault')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private int $vaultCapacity = 10;

    #[ORM\OneToMany(mappedBy: 'vault', targetEntity: UserVaultSlot::class, orphanRemoval: true)]
    private Collection $slots;

    public function __construct()
    {
        $this->slots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getVaultCapacity(): int
    {
        return $this->vaultCapacity;
    }

    public function setVaultCapacity(int $vaultCapacity): self
    {
        $this->vaultCapacity = $vaultCapacity;
        return $this;
    }

    /**
     * @return Collection<int, UserVaultSlot>
     */
    public function getSlots(): Collection
    {
        return $this->slots;
    }

    public function addSlot(UserVaultSlot $slot): self
    {
        if (!$this->slots->contains($slot)) {
            $this->slots->add($slot);
            $slot->setVault($this);
        }
        return $this;
    }

    public function removeSlot(UserVaultSlot $slot): self
    {
        if ($this->slots->removeElement($slot)) {
            if ($slot->getVault() === $this) {
                $slot->setVault(null);
            }
        }
        return $this;
    }
}
