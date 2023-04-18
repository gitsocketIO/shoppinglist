<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ShoppingItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ShoppingItemRepository::class)]
#[ApiResource(
    shortName: 'item',
    description: 'item of shopping list.',
    operations: [
    new Get(),
    new GetCollection(),
    new Post(),
    new Put(),
    new Patch(),
    new Delete(),
],
    normalizationContext: [
    'groups' => ['item:read'],
],
    denormalizationContext: [
    'groups' => ['item:write'],
]
)]
class ShoppingItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['item:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['item:read', 'item:write', 'shareitem:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['item:read', 'item:write', 'shareitem:read'])]
    private ?string $logo = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['item:read', 'item:write'])]
    #[ApiFilter(SearchFilter::class)]
    private ?ShoppingList $list = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: ShoppingSharingItem::class, orphanRemoval: true)]
    #[Groups(['item:read'])]
    private Collection $shoppingSharingItems;

    public function __construct()
    {
        $this->shoppingSharingItems = new ArrayCollection();
    }

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getList(): ?ShoppingList
    {
        return $this->list;
    }

    public function setList(?ShoppingList $list): self
    {
        $this->list = $list;

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
            $shoppingSharingItem->setItem($this);
        }

        return $this;
    }

    public function removeShoppingSharingItem(ShoppingSharingItem $shoppingSharingItem): self
    {
        if ($this->shoppingSharingItems->removeElement($shoppingSharingItem)) {
            // set the owning side to null (unless already changed)
            if ($shoppingSharingItem->getItem() === $this) {
                $shoppingSharingItem->setItem(null);
            }
        }

        return $this;
    }
}
