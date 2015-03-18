<?php

namespace CodeLovers\DoctrineEncryptBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CodeLoversDoctrineEncryptBundle extends Bundle
{
    private static $hasMongoDb = false;
    private static $hasORM = false;
    public function __construct()
    {
        if (false === static::$hasMongoDb && class_exists('Doctrine\ODM\MongoDB\Types\Type')) {
            \Doctrine\ODM\MongoDB\Types\Type::registerType(TypeName::ENCRYPTED_TYPE_NAME, 'CodeLovers\DoctrineEncryptBundle\MongoDB\Type\EncryptedType');
            static::$hasMongoDb = true;
        }

        if (false === static::$hasORM && class_exists('Doctrine\DBAL\Types\Type')) {
            \Doctrine\DBAL\Types\Type::addType(TypeName::ENCRYPTED_TYPE_NAME, 'CodeLovers\DoctrineEncryptBundle\ORM\Type\EncryptedType');
            static::$hasORM = true;
        }
    }

    public function boot()
    {
        if (false === static::$hasORM && false === static::$hasMongoDb) {
            return;
        }

        $encryptor = $this->container->get('code_lovers.encryptor');

        if (true === static::$hasMongoDb) {
            /** @var MongoDB\Type\EncryptedType $type */
            $type = \Doctrine\ODM\MongoDB\Types\Type::getType(TypeName::ENCRYPTED_TYPE_NAME);
            $type->setEncryptor($encryptor)
                ->setSecret($this->container->getParameter('code_lovers.encryptor.secret'));
        }

        if (true === static::$hasORM) {
            /** @var ORM\Type\EncryptedType $type */
            $type = \Doctrine\DBAL\Types\Type::getType(TypeName::ENCRYPTED_TYPE_NAME);
            $type->setEncryptor($encryptor)
                ->setSecret($this->container->getParameter('code_lovers.encryptor.secret'));
        }
    }
}
