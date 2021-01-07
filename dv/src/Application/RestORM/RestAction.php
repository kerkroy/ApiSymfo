<?php

namespace Application\RestORM;

use Application\RestORM\Exceptions\RestMethodException;
use Application\RestORM\Action\ActionInterface;

/**
 * Action Adapter
 */
final class RestAction implements RestActionInterface
{
    /**
     * @var array
     */
    private array $actions = [];

    /**
     * @param ActionInterface $verbs
     */
    public function addActions(ActionInterface $verbs): void
    {
        $this->actions[] = $verbs;
    }

    /**
     * @param string $media
     * @return ActionInterface|null
     * @throws RestMethodException
     */
    public function getAction(string $media): ?ActionInterface
    {
        foreach ($this->actions as $action){
            /**  Application\RestORM\Action\ActionInterface $action */
            if( $action->support($media) ){
                return $action;
            }
        }

        throw new RestMethodException($media);
    }
}