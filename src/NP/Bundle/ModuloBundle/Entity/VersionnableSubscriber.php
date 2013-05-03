<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\Container;

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

        if(method_exists($entity, 'getRevision')){
            $old = clone $entity;
            $uow->persist($old);
            foreach($args->getEntityChangeSet() as $field => $value ){
                $old->{'set'.Container::camelize($field)}($value[0]);
            }
            //$uow->computeChangeSets();riena  faire

            $uow->commit($old);
        }
    }
}

?>
