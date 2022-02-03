<?php

namespace FruitBasket\Domain\Exception;

use FruitBasket\Domain\Exception\DomainExceptionInterface;

class ItemWrongTypeException extends \Exception implements DomainExceptionInterface
{
    
}