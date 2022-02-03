<?php

namespace FruitBasket\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use FruitBasket\Domain\Model\Basket\Basket;
use FruitBasket\Domain\Model\Item\Item;
use FruitBasket\Domain\Model\Item\ItemType;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $basket = new Basket('My Basket', 200.00);
        $items = [];
        $items[] = new Item(ItemType::WATERMELON, 100);
        $items[] = new Item(ItemType::WATERMELON, 50);
        foreach ($items as $item) {
            $item->setBasket($basket);
        }
        $basket->addItems($items);
        $manager->persist($basket);

        $manager->flush();
    }
}
