<?php

namespace Application\RestORM\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class RestMethodException extends Exception implements RestExceptionInterface
{
    public function __construct(
        string $message = '',
        $code = Response::HTTP_METHOD_NOT_ALLOWED,
        Exception $previous = null
    ) {
        parent::__construct(json_encode($message.' method is not available'), $code, $previous);
    }
}