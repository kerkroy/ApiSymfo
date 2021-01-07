<?php

namespace Application\RestORM;

use Application\RestORM\Action\ActionInterface;

interface RestActionInterface
{
    /**
     * @param ActionInterface $verbs
     */
    public function addActions(ActionInterface $verbs): void;

    /**
     * @param string $media
     * @return ActionInterface|null
     */
    public function getAction(string $media): ?ActionInterface;
}