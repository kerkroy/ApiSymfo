<?php

namespace Application\RestORM;

use Application\RestORM\EntityFactory\EntityFactory;
use Application\RestORM\Methods\ActionInterface;

interface RestORMInterface
{
    public function getMeta(string $entity, string $property);

    public function setEFRepositories(): void;

    public function getEntityfactory(): EntityFactory;

}