<?php
/**
 * @package DoctrineEncryptBundle
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 10.06.14
 * @time 20:40
 */

namespace CodeLovers\DoctrineEncryptBundle\ORM\Type;


use CodeLovers\DoctrineEncryptBundle\Encryptor\EncryptorInterface;
use CodeLovers\DoctrineEncryptBundle\TypeName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

class EncryptedType extends TextType
{

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * @var string
     */
    private $secret;

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return TypeName::ENCRYPTED_TYPE_NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $this->encryptor->encrypt($value, $this->secret);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $this->encryptor->decrypt($value, $this->secret);
    }

    /**
     * @param \CodeLovers\DoctrineEncryptBundle\Encryptor\EncryptorInterface $encryptor
     *
     * @return EncryptedType
     */
    public function setEncryptor($encryptor)
    {
        $this->encryptor = $encryptor;

        return $this;
    }

    /**
     * @param string $secret
     *
     * @return EncryptedType
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * If this Doctrine Type maps to an already mapped database type,
     * reverse schema engineering can't take them apart. You need to mark
     * one of those types as commented, which will have Doctrine use an SQL
     * comment to typehint the actual Doctrine Type.
     *
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return boolean
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
