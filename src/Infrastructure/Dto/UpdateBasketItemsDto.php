<?php

namespace FruitBasket\Infrastructure\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateBasketItemsDto extends BaseDto
{
    /**
     * @Assert\All({
     *      @Assert\Type("FruitBasket\Infrastructure\Dto\ItemDto")
     * })
     */
    protected array $items;

    public function getItems(): array
    {
        return $this->items;
    }

    public static function fromArray($data)
    {
        $self = new self();
        $items = [];
        foreach ($data as $item) {
            $items[] = ItemDto::fromArray($item);
        }
        $self->items = $items;
        return $self;
    }
}
