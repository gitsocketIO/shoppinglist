<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ShoppingSharingItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ShoppingSharingItemRepository::class)]
#[ApiResource(
shortName: 'share item',
    description: 'share item of shopping list.',
    operations: [
    new Get(),
    new GetCollection(),
    new Post(),
    new Put(),
    new Delete(),
],
    normalizationContext: [
    'groups' => ['shareitem:read'],
],
    denormalizationContext: [
    'groups' => ['shareitem:write'],
]
)]
class ShoppingSharingItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['shareitem:read', 'item:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'], fetch: "EAGER", inversedBy: 'shoppingSharingItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['shareitem:write', 'shareitem:read'])]
    #[ApiFilter(SearchFilter::class)]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingSharingItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['shareitem:read', 'shareitem:write'])]
    private ?ShoppingItem $item = null;

    #[ORM\OneToOne(mappedBy: 'sharingitem', cascade: ['persist', 'remove'])]
    #[Groups(['shareitem:write', 'shareitem:read', 'item:read'])]
    private ?ShoppingSharingUser $shoppingSharingUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getItem(): ?ShoppingItem
    {
        return $this->item;
    }

    public function setItem(?ShoppingItem $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getShoppingSharingUser(): ?ShoppingSharingUser
    {
        return $this->shoppingSharingUser;
    }

    public function setShoppingSharingUser(ShoppingSharingUser $shoppingSharingUser): self
    {
        // set the owning side of the relation if necessary
        if ($shoppingSharingUser->getSharingitem() !== $this) {
            $shoppingSharingUser->setSharingitem($this);
        }

        $this->shoppingSharingUser = $shoppingSharingUser;

        return $this;
    }
}
