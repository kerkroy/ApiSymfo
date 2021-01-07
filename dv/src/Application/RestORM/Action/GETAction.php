<?php

namespace Application\RestORM\Action;

class GETAction extends ActionDecorator implements ActionInterface
{
    use ActionPaging;

    /**
     * @var array
     */
    private array $entity = [];

    /**
     * @var array
     */
    protected array $paging = [
        'total' => 0,
        'limit' => null,
        'page' => 0
    ];

    /**
     * @param array $arguments
     * @param array $entity
     * @param array $paging
     * @param int $offset
     * @return array
     */
    public function index(array $arguments, array $entity, array $paging = [], int $offset = 0 ): array
    {
        $paging['total'] = $this->getMeta($entity['name'])->count($arguments);

        if( isset( $paging['page']) && isset( $paging['limit']) ){

            if ( (int) $paging['page'] === 0 ||
                !is_numeric ( $paging['page']) ||
                !is_numeric ( $paging['limit'])
            ){
                return $this->retrieveAction();
            }

            $this->setPaging($paging);
            $offset = ceil ($paging['total'] / ( $paging['total'] / $paging['limit'] ) ) * ( $paging['page'] - 1 );
        }

        $this->entity = ( $paging['total'] > 0 ) ?
            $this->getMeta($entity['name'])->findBy(
                $arguments,
                [ $this->getMeta($entity['name'],'identifier') => 'ASC'],
                $this->paging['limit'],
                (int) $offset
            ) :
            []
        ;

        return $this->retrieveAction();
    }

    /**
     * @return array
     */
    public function retrieveAction (): array
    {
        return ($this->paging['limit'] === null || $this->paging['page'] === 0)? $this->entity : [
            'paging' => $this->paging,
            'result' => $this->entity,
        ];
    }
}