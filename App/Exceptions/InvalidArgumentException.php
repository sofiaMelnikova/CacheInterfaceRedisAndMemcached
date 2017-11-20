<?php

namespace App\Exceptions;

use App\Interfaces\InvalidArgumentExceptionInterface;

class InvalidArgumentException extends CacheException implements InvalidArgumentExceptionInterface {

}