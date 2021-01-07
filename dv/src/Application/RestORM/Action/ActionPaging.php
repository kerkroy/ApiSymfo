<?php

namespace Application\RestORM\Action;

trait ActionPaging
{
    /**
     * @param int $total
     * @param array $paging
     */
    public function setPaging(array $paging): void
    {
        $this->paging =  [
            'total' => $paging['total'],
            'limit' => (int) $paging['limit'],
            'page' => $paging['page']."/".(ceil($paging['total'] / $paging['limit']) )
        ];
    }

    /**
     * @param string|null $uri
     */
    public function addHyperMedias(string $uri = null): void
    {
        if(!is_null($uri) && preg_match('/\d*\/\d*/',$this->paging['page']))
        {
            list($actualPage, $totalPages) = explode('/',$this->paging['page']);
            $previousPage = $actualPage - 1;
            $nextPage = $actualPage + 1;

            if( (int) $actualPage === 1 ){
                $this->paging['next'] = str_replace("page=$actualPage", "page=$nextPage", $uri);
            } elseif ( $totalPages <= $actualPage ) {
                $this->paging['prev'] = str_replace("page=$actualPage", "page=$previousPage", $uri);
            } else {
                $this->paging['prev'] = str_replace("page=$actualPage", "page=$previousPage", $uri);
                $this->paging['next'] = str_replace("page=$actualPage", "page=$nextPage", $uri);
            }
        }
    }
}