<?php

namespace Application\RestORM\Action;

interface ActionInterface
{
    /**
     * @param array $message
     * @param array $entity
     * @param array $repositories
     * @return mixed
     */
    public function index(array $message, array $entity, array $repositories);

    /**
     * @param string $media
     * @return bool
     */
    public function support(string $media): bool;

    /**
     * @return array
     */
    public function retrieveAction (): array;
}