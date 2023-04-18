<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ShoppingSharingUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ShoppingSharingUserRepository::class)]
#[ApiResource(
shortName: 'share user',
    description: 'share user of shopping list.',
    operations: [
    new Get(),
    new GetCollection(),
    new Post(),
    new Put(),
    new Delete(),
],
    normalizationContext: [
    'groups' => ['shareuser:read'],
],
    denormalizationContext: [
    'groups' => ['shareuser:write'],
]
)]
class ShoppingSharingUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'], inversedBy: 'shoppingSharingUser')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['shareuser:read', 'shareuser:write'])]
    private ?ShoppingSharingItem $sharingitem = null;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'], fetch: "EAGER", inversedBy: 'shoppingSharingUsers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['shareuser:write', 'shareuser:read', 'shareitem:read', 'shareitem:write', 'item:read'])]
    private ?user $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSharingitem(): ?ShoppingSharingItem
    {
        return $this->sharingitem;
    }

    public function setSharingitem(ShoppingSharingItem $sharingitem): self
    {
        $this->sharingitem = $sharingitem;

        return $this;
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
}
