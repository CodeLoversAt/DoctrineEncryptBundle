<?php
/**
 * @package DoctrineEncryptBundle
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 10.06.14
 * @time 20:37
 */

namespace CodeLovers\DoctrineEncryptBundle\MongoDB\Type;


use CodeLovers\DoctrineEncryptBundle\Encryptor\EncryptorInterface;
use Doctrine\DBAL\Types\StringType;

class EncryptedType extends StringType
{
    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * @var string
     */
    private $secret;

    public function convertToDatabaseValue($value)
    {
        return $this->encryptor->encrypt($value, $this->secret);
    }

    public function convertToPHPValue($value)
    {
        return $this->encryptor->decrypt($value, $this->secret);
    }

    public function closureToPHP()
    {
        return '$return = \\Doctrine\\ODM\\MongoDB\\Types\\Type::getType(\'cl_encrypted\')->convertToPHPValue($value);';
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
}
