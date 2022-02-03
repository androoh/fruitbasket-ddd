<?php

namespace FruitBasket\Infrastructure\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateBasketDto extends BaseDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @Assert\Length(max=255)
     */
    protected string $name;

    public function getName(): string
    {
        return $this->name;
    }
}
