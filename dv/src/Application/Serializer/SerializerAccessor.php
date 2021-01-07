<?php

namespace Application\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerAccessor
{
    /**
     * @var string[]
     */
    const FORMATS = [
        'application/json' => 'json',
        'application/xml' => 'xml',
        'text/csv' => 'csv',
        'application/x-yaml' => 'yaml'
    ];

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * SerializerAccessor constructor.
     */
    public function __construct()
    {
        $encoders = [new JsonEncoder(), new CsvEncoder([]), new XmlEncoder(), new YamlEncoder()]; // Add several encoders if needed
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizers = [new PropertyNormalizer($classMetadataFactory), new DateTimeNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param $subject
     * @param string $encoder
     * @param string $group
     * @return string
     */
    public function serialize($subject, string $encoder = 'application/json', string $group): string
    {
        return $this->serializer->serialize(
            $subject,
            self::FORMATS[$encoder],
            ['groups' => $group]
        );

    }
}