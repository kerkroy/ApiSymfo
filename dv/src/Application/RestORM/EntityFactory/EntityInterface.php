<?php

namespace Application\RestORM\EntityFactory;

interface EntityInterface
{
    /**
     * @param string $property
     * @param $value
     */
    public function setProperty(string $property, $value): void;
}