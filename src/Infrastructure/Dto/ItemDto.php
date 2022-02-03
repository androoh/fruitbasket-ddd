<?php

namespace FruitBasket\Infrastructure\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ItemDto extends BaseDto
{
    /**
     * @Assert\NotBlank
     */
    protected string $type;
    /**
     * @Assert\NotBlank
     * @Assert\Positive
     */
    protected float $weight;

    public function getType(): string
    {
        return $this->type;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }
}
