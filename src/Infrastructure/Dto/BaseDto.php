<?php

namespace FruitBasket\Infrastructure\Dto;

use FruitBasket\Domain\DomainDtoInterface;

abstract class BaseDto implements DomainDtoInterface
{
    public static function fromArray($data)
    {
        $self = new static();
        foreach ($data as $property => $value) {
            if (property_exists($self, $property)) {
                $self->{$property} = $value;
            }
        }
        return $self;
    }
}
