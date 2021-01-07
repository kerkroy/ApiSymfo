<?php

namespace Application\RestORM;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Application\RestORM\Action\ActionInterface;

class RestPass
{
    /**
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public static function process(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(RestActionInterface::class);

        if(!$container->get('RestAction')){
            return; 
        }

        $definition = $container->findDefinition('RestAction');
        $taggedServices = $container->findTaggedServiceIds('Action');

        foreach( $taggedServices as $taggedService => $id){
            $definition->addMethodCall('addActions', [new Reference($taggedService)]);
        }
    }
}