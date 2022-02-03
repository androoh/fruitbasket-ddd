<?php

namespace FruitBasket\Domain\Model\Basket;

use Doctrine\Common\Collections\ArrayCollection;
use FruitBasket\Domain\Model\Item\Item;
use Doctrine\Common\Collections\Collection;
use FruitBasket\Domain\Exception\BasketIsFullException;
use FruitBasket\Domain\Exception\BasketMaxCapacityPositiveException;


class Basket
{
    private int $id;
    private string $name;
    private float $maxCapacity;
    private Collection $items;

    public function __construct(string $name, float $maxCapacity)
    {
        $this->maxCapacityIsPositive($maxCapacity);
        $this->name = $name;
        $this->maxCapacity = $maxCapacity;
        $this->items = new ArrayCollection();
    }

    public function addItem(Item $item): self
    {
        $this->checkIfAllowedItemWeight($item);
        $this->items[] = $item;
        return $this;
    }

    public function addItems(array $newItems): void
    {
        foreach ($newItems as $item) {
            $this->addItem($item);
        }
    }

    public function maxCapacityIsPositive(float $maxCapacity): void
    {
        if ($maxCapacity < 0) {
            throw new BasketMaxCapacityPositiveException("Basket max capacity should be positive!");
        }
    }

    public function checkIfAllowedItemWeight(Item $newItem): void
    {
        $itemsTotalWeight = 0;
        foreach ($this->items as $item) {
            $itemsTotalWeight += $item->getWeight();
        }
        if ($itemsTotalWeight + $newItem->getWeight() > $this->maxCapacity) {
            throw new BasketIsFullException("Basket is full!");
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getMaxCapacity(): float
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(float $maxCapacity): self
    {
        $this->maxCapacityIsPositive($maxCapacity);
        $this->maxCapacity = $maxCapacity;
        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setItems(Collection $items): self
    {
        $this->items = $items;
        return $this;
    }
}
