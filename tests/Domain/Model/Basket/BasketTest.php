<?php
namespace FruitBasket\Tests\Domain\Model\Basket;

use PHPUnit\Framework\TestCase;
use FruitBasket\Domain\Model\Item\Item;
use FruitBasket\Domain\Model\Item\ItemType;
use FruitBasket\Domain\Model\Basket\Basket;
use FruitBasket\Domain\Exception\BasketIsFullException;
use FruitBasket\Domain\Exception\BasketMaxCapacityPositiveException;

final class BasketTest extends TestCase
{
    public function testBasketAddItems(): void 
    {
        $basket = new Basket('My Basket', 10);
        $basket->addItems([
            new Item(ItemType::ORANGE, 5),
            new Item(ItemType::WATERMELON, 1),
            new Item(ItemType::WATERMELON, 1)
        ]);
        $this->assertCount(3, $basket->getItems());
    }

    public function testBasketIsFull(): void
    {
        $this->expectException(BasketIsFullException::class);
        $basket = new Basket('My Basket', 10);
        $basket->addItems([
            new Item(ItemType::ORANGE, 5),
            new Item(ItemType::ORANGE, 6)
        ]);
    }

    public function testBasketMaxCapacityIsPositive(): void
    {
        $this->expectException(BasketMaxCapacityPositiveException::class);
        new Basket('My Basket', -10);
    }
}