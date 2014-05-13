<?php
/**
 * @package DoctrineEncryptBundle
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 13.05.14
 * @time 16:57
 */

namespace CodeLovers\DoctrineEncryptBundle\Subscriber;


use Doctrine\ORM\Events;

class ORMEncryptionSubscriber extends AbstractEncryptionSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
            Events::postLoad
        );
    }
}