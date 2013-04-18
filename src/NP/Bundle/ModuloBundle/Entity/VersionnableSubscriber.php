<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;

class VersionnableSubscriber implements EventSubscriber {

    /**
     * Constructor
     *
     */
    public function __construct() {
    }

    public function getSubscribedEvents() {
        return array(
            Events::preUpdate,
        );
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        $new = clone $entity;

        $new->setRevision($entity->getRevision()+1);

        $uow->detach($entity);
        $uow->persist($new);
    }
}

?>
