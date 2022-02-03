<?php
namespace FruitBasket\Tests\Domain\Model\Item;

use FruitBasket\Domain\Exception\ItemWrongTypeException;
use FruitBasket\Domain\Model\Item\ItemType;
use PHPUnit\Framework\TestCase;
use FruitBasket\Domain\Model\Item\Item;

final class ItemTest extends TestCase
{
    public function testItemValidType(): void
    {
        $item = new Item(ItemType::WATERMELON, 10);
        $this->assertSame(ItemType::WATERMELON, $item->getType());
    }

    public function testItemInvalidType(): void 
    {
        $this->expectException(ItemWrongTypeException::class);
        new Item('wrong type', 10);
    }
}