<?php

namespace Application\RestORM\Action;

use Application\RestORM\Exceptions\RestEntityException;
use Application\RestORM\RestORM;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ActionDecorator
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var RestORM
     */
    protected RestORM $restORM;

    /**
     * ActionDecorator constructor.
     * @param RestORM $restorm
     */
    public function __construct(RestORM $restorm)
    {
        $this->em = $restorm->em;
        $this->restORM = $restorm;
    }

    /**
     * @param string $entity
     * @param string $property
     * @return RestEntityException|EntityRepository|\Exception|null
     */
    protected function getMeta(string $entity, string $property = 'class')
    {
        try {
            return $this->restORM->getMeta($entity, $property);
        } catch (RestEntityException $e) {
            return $e;
        }
    }

    /**
     * @param string $media
     * @return bool
     */
    public function support(string $media): bool
    {
        return $media == ((new \ReflectionClass($this))->getShortName());
    }

}
