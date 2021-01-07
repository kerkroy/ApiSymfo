<?php

namespace Application\RestORM;

use Application\RestORM\Exceptions\RestMethodException;
use Application\RestORM\Action\ActionInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class RestFactory
{
    /**
     * @var ActionInterface
     */
    private ActionInterface $maker;

    /**
     * @var false|resource|string|null
     */
    private $body;

    /**
     * @var string
     */
    public string $method;

    /**
     * @var array
     */
    private array $entity;

    /**
     * @var RestAction
     */
    private RestAction $restAction;

    /**
     * @var string[]
     */
    const PAGING = [
        'page' => null,
        'limit' => null
    ];

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * RestFactory constructor.
     * @param RequestStack $requestStack
     * @param RestAction $restAction
     * @throws RestMethodException
     */
    public function __construct(RequestStack $requestStack, RestAction $restAction)
    {
        $this->requestStack = $requestStack;
        $this->restAction = $restAction;
        $this->entity = $this->getRequestedEntity();
        $this->method = $requestStack->getCurrentRequest()->getMethod();
        $this->maker = $this->restAction->getAction($this->method.'Action');
        $this->body = $this->messageFormater() ;
    }

    /**
     * @param string|null $action
     * @return array
     * @throws RestMethodException
     */
    public function getContext(string $action = null): array
    {
        $this->maker = $this->restAction->getAction($action ?? $this->method.'Action');

        return $this->maker->index(
            $this->body,
            $this->entity,
            array_intersect_key($this->requestStack->getCurrentRequest()->query->all(),SELF::PAGING)
        );

    }

    /**
     * @param string|null $action
     * @throws RestMethodException
     * @return mixed
     */
    public function do(string $action = null)
    {
        $this->getContext($action);
        if(is_callable($this->maker, 'addHyperMedias')){
            $this->maker->addHyperMedias($this->requestStack->getCurrentRequest()->getRequestUri());
        }
        return $this->maker->retrieveAction();
    }

    /**
     * @return array
     */
    private function getRequestedEntity(): array
    {
        return [
            'name' => ucfirst($this->requestStack->getCurrentRequest()->attributes->get('entity')),
            'value' => $this->requestStack->getCurrentRequest()->attributes->get('id')
        ];
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->requestStack->getCurrentRequest()->getAcceptableContentTypes()[0];
    }

    /**
     * @return array
     */
    private function messageFormater(): array
    {
        return array_merge(
            [],
            json_decode($this->requestStack->getCurrentRequest()->getContent(), true),
            array_diff_key($this->requestStack->getCurrentRequest()->query->all(), SELF::PAGING),
            $this->entity['value'] ? [$this->maker->getMeta($this->entity['name'], 'identifier') => $this->entity['value']]: []
        );
    }
}