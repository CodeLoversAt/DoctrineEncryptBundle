<?php
/**
 * @package DoctrineEncryptBundle
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 13.05.14
 * @time 16:55
 */

namespace CodeLovers\DoctrineEncryptBundle\Subscriber;


use CodeLovers\DoctrineEncryptBundle\Encryptor\EncryptorInterface;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

abstract class AbstractEncryptionSubscriber implements EventSubscriber
{
    const ANNOTATION_ENCRYPTED_ENTITY = 'CodeLovers\\DoctrineEncryptBundle\\Annotation\\EncryptedEntity';
    const ANNOTATION_ENCRYPT = 'CodeLovers\\DoctrineEncryptBundle\\Annotation\\Encrypt';

    const DIRECTION_ENCRYPT = 0;
    const DIRECTION_DECRYPT = 1;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var EncryptorInterface
     */
    protected $encryptor;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @param \CodeLovers\DoctrineEncryptBundle\Encryptor\EncryptorInterface $encryptor
     * @param \Doctrine\Common\Annotations\Reader $reader
     * @param string $secret
     */
    public function __construct(EncryptorInterface $encryptor, Reader $reader, $secret)
    {
        $this->encryptor = $encryptor;
        $this->reader = $reader;
        $this->secret = $secret;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->processObject($args->getObject(), self::DIRECTION_ENCRYPT);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->processObject($args->getObject(), self::DIRECTION_ENCRYPT);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $this->processObject($args->getObject(), self::DIRECTION_DECRYPT);
    }

    protected function processObject($object, $direction = self::DIRECTION_ENCRYPT)
    {
        $reflectionClass = new \ReflectionClass($object);

        if (0 === strpos($reflectionClass->getName(), 'Proxies\\')) {
            $reflectionClass = $reflectionClass->getParentClass();
        }

        $annotation = $this->reader->getClassAnnotation($reflectionClass, self::ANNOTATION_ENCRYPTED_ENTITY);

        if (null !== $annotation) {
            $this->processFields($reflectionClass, $object, $direction);
        }
    }

    protected function processFields(\ReflectionClass $reflectionClass, $object, $direction = self::DIRECTION_ENCRYPT)
    {
        foreach ($reflectionClass->getProperties() as $property) {
            $annotation = $this->reader->getPropertyAnnotation($property, self::ANNOTATION_ENCRYPT);

            if (null !== $annotation) {
                $property->setAccessible(true);

                $value = $property->getValue($object);

                if (self::DIRECTION_ENCRYPT === $direction) {
                    $value = $this->encryptor->encrypt($value, $this->secret);
                } elseif (self::DIRECTION_DECRYPT === $direction) {
                    $value = $this->encryptor->decrypt($value, $this->secret);
                } else {
                    throw new \InvalidArgumentException('invalid direction');
                }

                $property->setValue($object, $value);
            }
        }
    }
}