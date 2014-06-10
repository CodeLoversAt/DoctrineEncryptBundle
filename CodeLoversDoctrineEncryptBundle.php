<?php

namespace CodeLovers\DoctrineEncryptBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CodeLoversDoctrineEncryptBundle extends Bundle
{
    private $hasMongoDb = false;
    private $hasORM = false;
    public function __construct()
    {
        if (class_exists('Doctrine\ODM\MongoDB\Mapping\Types\Type')) {
            \Doctrine\ODM\MongoDB\Types\Type::registerType(TypeName::ENCRYPTED_TYPE_NAME, 'CodeLovers\DoctrineEncryptBundle\MongoDB\Type\EncryptedType');
            $this->hasMongoDb = true;
        }

        if (class_exists('Doctrine\DBAL\Types\Type')) {
            \Doctrine\DBAL\Types\Type::addType(TypeName::ENCRYPTED_TYPE_NAME, 'CodeLovers\DoctrineEncryptBundle\ORM\Type\EncryptedType');
            $this->hasORM = true;
        }
    }

    public function boot()
    {
        if (false === $this->hasORM && false === $this->hasMongoDb) {
            return;
        }

        $encryptor = $this->container->get('code_lovers.encryptor');

        if (true === $this->hasMongoDb) {
            /** @var MongoDB\Type\EncryptedType $type */
            $type = \Doctrine\ODM\MongoDB\Types\Type::getType(TypeName::ENCRYPTED_TYPE_NAME);
            $type->setEncryptor($encryptor)
                ->setSecret($this->container->getParameter('code_lovers.encryptor.secret'));
        }

        if (true === $this->hasORM) {
            /** @var ORM\Type\EncryptedType $type */
            $type = \Doctrine\DBAL\Types\Type::getType(TypeName::ENCRYPTED_TYPE_NAME);
            $type->setEncryptor($encryptor)
                ->setSecret($this->container->getParameter('code_lovers.encryptor.secret'));
        }
    }
}
