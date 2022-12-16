<?php

namespace App\Entity;

use App\Features\Auth\RegisterUser\RegisterUserCommand;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    public string $email;

    /** @var string[] */
    #[ORM\Column]
    private array $roles;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    public string $password;

    #[ORM\Column(length: 255)]
    public string $firstname;

    #[ORM\Column(length: 255)]
    public string $lastname;

    #[ORM\Column(type: 'datetime_immutable')]
    public ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    public ?\DateTimeImmutable $updatedAt;

    private function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $password
    ) {
        $this->id = null;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = null;
        $this->updatedAt = null;
        $this->roles = [];
    }

    public static function fromRegisterUserCommand(RegisterUserCommand $command): self
    {
        return new self(
            $command->firstname,
            $command->lastname,
            $command->email,
            ''
        );
    }

    public function withHashedPassword(string $hashedPassword): self
    {
        $this->password = $hashedPassword;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
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
