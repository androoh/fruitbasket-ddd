<?php

namespace FruitBasket\Infrastructure\Service;

use FruitBasket\Infrastructure\Repository\Doctrine\BasketRepository;
use FruitBasket\Domain\Model\Basket\Basket;
use FruitBasket\Domain\Model\Item\Item;
use FruitBasket\Domain\Service\BasketServiceInterface;
use FruitBasket\Domain\DomainDtoInterface;

class BasketService implements BasketServiceInterface
{
    private BasketRepository $basketRepository;

    public function __construct(BasketRepository $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function getBasket(int $id): Basket
    {
        return $this->basketRepository->findById($id);
    }

    public function getBaskets(): array
    {
        return $this->basketRepository->findAll();
    }

    public function createBasket(DomainDtoInterface $createBasketDto): Basket
    {
        $basket = new Basket($createBasketDto->getName(), $createBasketDto->getMaxCapacity());
        $this->basketRepository->save($basket);
        return $basket;
    }

    public function updateBasket(int $id, DomainDtoInterface $updateBasketDto): Basket
    {
        $basket = $this->getBasket($id);
        $basket->setName($updateBasketDto->getName());
        $this->basketRepository->save($basket);
        return $basket;
    }

    public function addItems(int $id, DomainDtoInterface $updateBasketItemsDto): Basket
    {
        $basket = $this->getBasket($id);
        foreach ($updateBasketItemsDto->getItems() as $itemDto) {
            $item = new Item($itemDto->getType(), $itemDto->getWeight());
            $item->setBasket($basket);
            $basket->addItem($item);
        }
        $this->basketRepository->save($basket);
        return $basket;
    }

    public function removeBasketItems(int $id): Basket
    {
        $basket = $this->getBasket($id);
        $this->basketRepository->clearItems($basket);
        return $basket;
    }

    public function removeBasket(int $id): void
    {
        $basket = $this->getBasket($id);
        $this->basketRepository->remove($basket);
    }
}
