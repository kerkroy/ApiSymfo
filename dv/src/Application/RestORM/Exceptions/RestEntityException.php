<?php

namespace Application\RestORM\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class RestEntityException extends Exception implements RestExceptionInterface
{
    public function __construct(
        string $message = '',
        $code = Response::HTTP_NOT_FOUND,
        Exception $previous = null
    ) {
        parent::__construct(json_encode($message.' entity is not available'), $code, $previous);
    }
}