<?php

namespace FruitBasket\Domain\Exception;

use FruitBasket\Domain\Exception\DomainExceptionInterface;

class BasketMaxCapacityPositiveException extends \Exception implements DomainExceptionInterface
{

}