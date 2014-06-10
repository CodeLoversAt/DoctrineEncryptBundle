<?php
/**
 * @package DoctrineEncryptBundle
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 10.06.14
 * @time 21:20
 */

namespace CodeLovers\DoctrineEncryptBundle\MongoDB\Annotation;
use CodeLovers\DoctrineEncryptBundle\TypeName;
use Doctrine\ODM\MongoDB\Mapping\Annotations\AbstractField;

/**
 * @Annotation
 */
class EncryptedType extends AbstractField
{
    public $type = TypeName::ENCRYPTED_TYPE_NAME;
} 