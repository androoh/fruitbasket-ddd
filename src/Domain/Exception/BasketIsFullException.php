<?php

namespace FruitBasket\Domain\Exception;

use FruitBasket\Domain\Exception\DomainExceptionInterface;

class BasketIsFullException extends \Exception implements DomainExceptionInterface
{
}
