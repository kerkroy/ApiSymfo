<?php

namespace Ui\Controller;

use Application\RestORM\Exceptions\RestMethodException;
use Application\RestORM\RestFactory;
use Application\Serializer\SerializerAccessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/*
   __________  __  ______     ______            __             ____
  / ____/ __ \/ / / / __ \   / ____/___  ____  / /__________  / / /__  _____
 / /   / /_/ / / / / / / /  / /   / __ \/ __ \/ __/ ___/ __ \/ / / _ \/ ___/
/ /___/ _, _/ /_/ / /_/ /  / /___/ /_/ / / / / /_/ /  / /_/ / / /  __/ /
\____/_/ |_|\____/_____/   \____/\____/_/ /_/\__/_/   \____/_/_/\___/_/

*/

class CrudController extends AbstractController
{
    /**
     * @param SerializerAccessor $serializer
     * @param RestFactory $rest
     * @return Response
     * @throws RestMethodException
     */
    public function crud_user(SerializerAccessor $serializer, RestFactory $rest): Response
    {
        return new Response($serializer->serialize( $rest->do(), $rest->getFormat(), $group ?? $rest->method));
    }
}