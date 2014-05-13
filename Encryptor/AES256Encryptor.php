<?php
/**
 * @package DoctrineEncryptBundle
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 13.05.14
 * @time 16:39
 */

namespace CodeLovers\DoctrineEncryptBundle\Encryptor;


class AES256Encryptor implements EncryptorInterface
{
    /**
     * @var string
     */
    private $initVector;

    public function __construct()
    {

        $this->initVector = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
    }

    /**
     *{@inheritDoc}
     */
    public function encrypt($plain, $key)
    {
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $plain, MCRYPT_MODE_ECB, $this->initVector));
    }

    /**
     *{@inheritDoc}
     */
    public function decrypt($encrypted, $key)
    {
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_ECB, $this->initVector);
    }
}