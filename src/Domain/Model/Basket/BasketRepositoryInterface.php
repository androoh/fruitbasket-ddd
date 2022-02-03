<?php

namespace FruitBasket\Domain\Model\Basket;

interface BasketRepositoryInterface
{
    public function findById(int $id): Basket;
    public function getAll();
    public function clearItems(Basket $basket): Basket;
    public function save(Basket $basket);
    public function remove(Basket $basket);
}
