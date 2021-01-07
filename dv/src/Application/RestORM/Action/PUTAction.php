<?php

namespace Application\RestORM\Action;

class PUTAction extends ActionDecorator implements ActionInterface
{
    /**
     * @var mixed
     */
    private $entity;

    /**
     * @param array $arguments
     * @param array $entity
     * @param array $paging
     * @return mixed
     */
    public function index(array $arguments, array $entity, array $paging = [] ): array
    {
        $this->entity = $this->restORM->getEntityfactory()->makeEntity($entity['name'], $arguments);
        return [$this->entity];
    }

    /**
     * @return array
     */
    public function retrieveAction (): array
    {
        $this->em->persist($this->entity);
        $this->em->flush();

        return [$this->entity];
    }
}