<?php

namespace FruitBasket\Infrastructure\Repository\Doctrine;

use FruitBasket\Domain\Model\Basket\Basket;
use FruitBasket\Domain\Model\Basket\BasketRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class BasketRepository extends ServiceEntityRepository implements BasketRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Basket::class);
    }

    public function findById(int $id): Basket
    {
        return $this->_em->getRepository(Basket::class)->find($id);
    }

    public function getAll(): array
    {
        return $this->_em->getRepository(Basket::class)->findAll();
    }

    public function save(Basket $basket): void
    {
        $this->_em->wrapInTransaction(function ($em) use ($basket) {
            $em->persist($basket);
        });
    }

    public function clearItems(Basket $basket): Basket
    {
        foreach ($basket->getItems() as $item) {
            $this->_em->remove($item);
        }
        $basket->getItems()->clear();
        $this->_em->flush();
        return $basket;
    }

    public function remove(Basket $basket): void
    {
        $this->_em->remove($basket);
        $this->_em->flush();
    }
}
