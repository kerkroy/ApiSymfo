<?php

namespace Application\RestORM\EntityFactory;

use Doctrine\Common\Collections\ArrayCollection;

class EntityFactory
{
    use PropertyFormater;

    /**
     * @var array
     */
    public array $repositories = [];

    /**
     * @param $entity
     * @param array $message
     * @param string $entityName
     * @return mixed
     */
    public function hydrate($entity, array $message, string $entityName)
    {
        $message = $this->formatArgs($message, $entity, $entityName);

        foreach ($message as $property => $value){
            /**  string $item  */
            /**  string|array $value  */
            if(!is_array($value)){
                $entity->setProperty($property, $value);
            } else {
                $this->makeRelation($entity, $property, $value);
            }
        }

        return $entity;
    }

    /**
     * @param string $property
     * @param array $message
     */
    private function makeRelation($entity, string $property, array $message): void
    {
        $relation = new ArrayCollection();

        foreach( $message as $item => $value ) {
            /**  string $item  */
            /**  string|array $value  */
            if (is_array($value)) {
                $relation = $this->RelationDecorator($relation, $property, $value);
            } else {
                $relation = $this->RelationDecorator($relation, $property, $message);
            }
        }

        $entity->setProperty($property, $relation);
    }

    /**
     * @param $relation
     * @param string $property
     * @param array $message
     * @return array|mixed
     */
    private function RelationDecorator($relation, string $property, array $message)
    {
        if(substr($property, -1) == "s"){
            $relation->add($this->makeEntity(substr_replace($property ,"",-1), $message));
        } else {
            $relation = $this->makeEntity($property, $message);
        }
        return $relation;
    }

    /**
     * @param string $entity
     * @param array $message
     * @return array|mixed
     */
    public function makeEntity(string $entity, array $message)
    {
        $entity = ucfirst($entity);
        $metas = $this->repositories[$entity];
        list($identifier, $class, $fullName) = [ $metas['identifier'], $metas['class'], $metas['name'] ];
        $exist = isset($message[$identifier]) ? $class->findOneBy([ $identifier => $message[$identifier] ]) : [];

        return !empty($exist) ? $exist : $this->hydrate(new $fullName(), $message, $entity);
    }
}