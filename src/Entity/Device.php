<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Index(columns: ['name'], name: 'idx_device_name', options: ['unique' => true])]
#[ORM\HasLifecycleCallbacks]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public string $name;

    #[ORM\Column(length: 255)]
    public string $address;

    #[ORM\Column]
    public bool $isActive;

    #[ORM\Column(type: 'datetime_immutable')]
    public ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    public ?\DateTimeImmutable $updatedAt;

    public function __construct(
        string $name,
        string $address,
    ) {
        $this->id = null;
        $this->name = $name;
        $this->address = $address;
        $this->isActive = false;
        $this->createdAt = null;
        $this->updatedAt = null;
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
