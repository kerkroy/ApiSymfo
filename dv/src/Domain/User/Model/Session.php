<?php

namespace Domain\User\Model;

use Application\RestORM\EntityFactory\EntityInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/** @ORM\Entity */
class Session implements EntityInterface
{

    /**
     * @ORM\Id 
     * @ORM\Column(length=140)
     * @Groups({"GET","PUT","POST"})
     */
    private $token;

    /**
     * @ORM\Column(type="datetime", name="connected_at")
     * @Groups({"GET","PUT"})
     */
    private $connectedAt;

    public function __construct(){
        $this->connectedAt = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getConnectedAt(): DateTime
    {
        return $this->connectedAt;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $property
     * @param $value
     */
    public function setProperty(string $property, $value): void
    {
        $this->$property = $value;
    }
}