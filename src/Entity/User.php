<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['username'], message: 'It looks like another user took your username.')]
#[ApiResource(
shortName: 'user',
    description: 'Users of shopping list.',
    operations: [
    new Get(),
    new GetCollection()
],
    normalizationContext: [
    'groups' => ['user:read'],
],
    denormalizationContext: [
    'groups' => ['user:write'],
]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'item:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['user:read'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'shareitem:read'])]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ShoppingSharingItem::class, orphanRemoval: true)]
    private Collection $shoppingSharingItems;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ShoppingSharingUser::class, orphanRemoval: true)]
    private Collection $shoppingSharingUsers;

    public function __construct()
    {
        $this->shoppingSharingItems = new ArrayCollection();
        $this->shoppingSharingUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int, ShoppingSharingItem>
     */
    public function getShoppingSharingItems(): Collection
    {
        return $this->shoppingSharingItems;
    }

    public function addShoppingSharingItem(ShoppingSharingItem $shoppingSharingItem): self
    {
        if (!$this->shoppingSharingItems->contains($shoppingSharingItem)) {
            $this->shoppingSharingItems->add($shoppingSharingItem);
            $shoppingSharingItem->setUser($this);
        }

        return $this;
    }

    public function removeShoppingSharingItem(ShoppingSharingItem $shoppingSharingItem): self
    {
        if ($this->shoppingSharingItems->removeElement($shoppingSharingItem)) {
            // set the owning side to null (unless already changed)
            if ($shoppingSharingItem->getUser() === $this) {
                $shoppingSharingItem->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ShoppingSharingUser>
     */
    public function getShoppingSharingUsers(): Collection
    {
        return $this->shoppingSharingUsers;
    }

    public function addShoppingSharingUser(ShoppingSharingUser $shoppingSharingUser): self
    {
        if (!$this->shoppingSharingUsers->contains($shoppingSharingUser)) {
            $this->shoppingSharingUsers->add($shoppingSharingUser);
            $shoppingSharingUser->setUser($this);
        }

        return $this;
    }

    public function removeShoppingSharingUser(ShoppingSharingUser $shoppingSharingUser): self
    {
        if ($this->shoppingSharingUsers->removeElement($shoppingSharingUser)) {
            // set the owning side to null (unless already changed)
            if ($shoppingSharingUser->getUser() === $this) {
                $shoppingSharingUser->setUser(null);
            }
        }

        return $this;
    }
}
