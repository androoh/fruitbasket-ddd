<?php

namespace FruitBasket\Infrastructure\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateBasketDto extends BaseDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @Assert\Length(max=255)
     */
    protected string $name;

    /**
     * @Assert\NotBlank
     */
    protected string $maxCapacity;

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxCapacity(): float
    {
        return $this->maxCapacity;
    }
}
