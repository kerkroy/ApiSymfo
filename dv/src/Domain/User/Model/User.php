<?php

namespace Domain\User\Model;

use Application\RestORM\EntityFactory\EntityInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Domain\Declaration\Model\Declaration;

/** @ORM\Entity */
class User implements EntityInterface
{

    /**
     * @ORM\Id 
     * @ORM\Column(length=140)
     * @Groups({"GET","PUT","POST","DELETE"})
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", name="connected_at")
     * @Groups({"GET","PUT"})
     */
    private $connectedAt;

    /**
     * @ORM\OneToMany(targetEntity=Declaration::class, mappedBy="user", cascade={"persist"})
     * @Groups({"GET","PUT","POST","DELETE"})
     */
    private $declarations;


    public function __construct() {
        $this->declarations = new ArrayCollection();
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeclarations(): ArrayCollection
    {
        return $this->declarations;
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