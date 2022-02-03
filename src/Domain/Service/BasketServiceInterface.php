<?php

namespace FruitBasket\Domain\Service;

use FruitBasket\Domain\DomainDtoInterface;
use FruitBasket\Domain\Model\Basket\Basket;

interface BasketServiceInterface
{
    public function getBasket(int $id): Basket;
    public function getBaskets(): array;
    public function createBasket(DomainDtoInterface $createBasketDto): Basket;
    public function updateBasket(int $id, DomainDtoInterface $updateBasketDto): Basket;
    public function addItems(int $id, DomainDtoInterface $updateBasketItemsDto): Basket;
    public function removeBasketItems(int $id): Basket;
    public function removeBasket(int $id): void;
}
