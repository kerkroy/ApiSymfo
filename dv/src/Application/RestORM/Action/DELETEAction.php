<?php

namespace Application\RestORM\Action;

class DELETEAction extends ActionDecorator implements ActionInterface
{
    /**
     * @var mixed
     */
    private $entity;

    /**
     * @param array $arguments
     * @param array $entity
     * @param array $paging
     * @return array
     */
    public function index(array $arguments, array $entity, array $paging = []): array
    {
        $this->entity = $this->getMeta($entity['name'])->findBy($arguments);
        return $this->entity;
    }

    /**
     * @return array
     */
    public function retrieveAction (): array
    {
        $this->em->remove($this->entity[0]);
        $this->em->flush();

        return $this->entity;
    }
}