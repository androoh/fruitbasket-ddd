<?php

namespace FruitBasket\Domain\Model\Item;

use FruitBasket\Domain\Exception\ItemWrongTypeException;
use FruitBasket\Domain\Model\Basket\Basket;

class Item
{
    private int $id;
    private string $type;
    private float $weight;
    private Basket $basket;
    private array $allowedTypes = [ItemType::APPLE, ItemType::ORANGE, ItemType::WATERMELON];

    public function __construct(string $type, float $weight)
    {
        $this->checkIfValidType($type);
        $this->type = $type;
        $this->weight = $weight;
    }

    public function checkIfValidType($type)
    {
        if (!in_array($type, $this->allowedTypes)) {
            throw new ItemWrongTypeException("Wrong Item Type");
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    public function getBasket(): Basket
    {
        return $this->basket;
    }

    public function setBasket(Basket $basket): self
    {
        $this->basket = $basket;
        return $this;
    }
}
