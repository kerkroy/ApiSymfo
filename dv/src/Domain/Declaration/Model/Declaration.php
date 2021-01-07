<?php

namespace Domain\Declaration\Model;

use Application\RestORM\EntityFactory\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Domain\User\Model\User;

/** @ORM\Entity */
class Declaration implements EntityInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(length=140)
     * @Groups({"GET","PUT","POST"})
     */
    private $ref;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="declarations", cascade={"persist"})
     * @ORM\JoinColumn(name="user_mail", referencedColumnName="email")
     */
    private $user;

    /**
     * @return string
     */
    public function getRef(): string
    {
        return $this->ref;
    }

    /**
     * @return mixed
     */
    public function getUser(): User
    {
        return $this->user;
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