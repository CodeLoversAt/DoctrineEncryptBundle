<?php
/**
 * @package DoctrineEncryptBundle
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 13.05.14
 * @time 16:37
 */

namespace CodeLovers\DoctrineEncryptBundle\Encryptor;


interface EncryptorInterface
{
    /**
     * encryptes the given plain text
     *
     * @param string $plain
     * @param string $key
     *
     * @return string
     */
    public function encrypt($plain, $key);

    /**
     * decrypts the given string and returns the original plain text
     *
     * @param string $encrypted
     * @param string $key
     *
     * @return string
     */
    public function decrypt($encrypted, $key);
} 