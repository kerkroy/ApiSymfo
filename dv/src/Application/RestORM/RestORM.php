<?php

namespace Application\RestORM;

use Application\RestORM\EntityFactory\EntityFactory;
use Application\RestORM\Exceptions\RestEntityException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * ORM Adapter
 */
final class RestORM implements RestORMInterface
{
    /**
     * @var array
     */
    private array $repositories = [];

    /**
     * @var EntityManagerInterface
     */
    public EntityManagerInterface $em;

    /**
     * @var EntityFactory
     */
    private EntityFactory $ef;

    /**
     * RestFactory constructor.
     * @param EntityManagerInterface $entityManager
     * @param EntityFactory $entityFactory
     */
    public function __construct(EntityManagerInterface $entityManager, EntityFactory $entityFactory)
    {
        $this->em = $entityManager;
        $this->ef = $entityFactory;

        $metas = $entityManager->getMetadataFactory()->getAllMetadata();

        foreach($metas as $meta){
            /**  Doctrine\\ORM\\Mapping\\ClassMetadata $meta */
            $parsed = explode('\\', $meta->getName());
            $this->repositories[ucfirst(end($parsed))] = [
                "name" => $meta->getName(),
                "class" => $entityManager->getRepository($meta->getName()),
                "identifier" => $meta->getIdentifier()[0],
                "mapping" => []
            ];


            foreach($meta->getFieldNames() as $field){
                $this->repositories[ucfirst(end($parsed))]["mapping"][$field] = [
                    "type" => $meta->fieldMappings[$field]["type"],
                    "length" => $meta->fieldMappings[$field]["length"]
                ];
            }
        };
    }

    /**
     * @param string $entity
     * @param string $property
     * @return EntityRepository|null|string
     * @throws RestEntityException
     */
    public function getMeta(string $entity, string $property)
    {
        if(isset($this->repositories[$entity])){
            $entity = $this->repositories[$entity][$property];
        } else {
            throw new RestEntityException($entity);
        }
        return $entity;
    }

    public function setEFRepositories(): void
    {
         $this->ef->repositories = $this->repositories;
    }

    /**
     * @return EntityFactory
     */
    public function getEntityfactory(): EntityFactory
    {
        return $this->ef;
    }
}