<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\DependencyInjection\Container;

class VersionnableSubscriber implements EventSubscriber {

    protected $container;

    /**
     * Constructor
     *
     */
    public function __construct($container) {
	$this->container = $container;
    }

    public function getSubscribedEvents() {
	return array(
	    Events::preUpdate,
	    Events::onFlush
	);
    }

    public function preUpdate(PreUpdateEventArgs $args) {
	$entity = $args->getEntity();
	$em = $args->getEntityManager();
	$uow = $em->getUnitOfWork();
	$securityContext = $this->container->get('security.context');

	if (
	    !$securityContext->getToken()->getUser()->hasRole('ROLE_SUPER_ADMIN') &&
	    method_exists($entity, 'setPublished')
	) {
	    if (
		(
		$entity instanceof Event ||
		$entity instanceof Step ||
		$entity instanceof News ||
		$entity instanceof Gallery ||
		$entity instanceof Category ||
		$entity instanceof Resources
		) &&
		(
		$args->hasChangedField('title') ||
		$args->hasChangedField('description') ||
		$args->hasChangedField('start') ||
		$args->hasChangedField('stop') ||
		$args->hasChangedField('date')
		)
	    ) {

		$md = $em->getClassMetadata(get_class($entity));
		$uow->scheduleExtraUpdate(
		    $entity, array('published' => array($entity->getPublished(), false))
		);
		$uow->recomputeSingleEntityChangeSet($md, $entity);
	    }
	}
    }

    public function onFlush(OnFlushEventArgs $args) {
	$em = $args->getEntityManager();
	$uow = $em->getUnitOfWork();
	$securityContext = $this->container->get('security.context');
	
	$entities = array_merge($uow->getScheduledEntityInsertions(),$uow->getScheduledEntityUpdates());
	
	foreach ($entities AS $entity) {
	    if (
		!$securityContext->getToken()->getUser()->hasRole('ROLE_SUPER_ADMIN') &&
		$entity instanceof Picture &&
		method_exists($entity->getParent(), 'setPublished')
	    ) {
		$md = $em->getClassMetadata(get_class($entity->getParent()));
		$uow->scheduleExtraUpdate(
		    $entity->getParent(), array('published' => array($entity->getParent()->getPublished(), false))
		);
		$uow->recomputeSingleEntityChangeSet($md, $entity->getParent());
	    }
	}
    }
}

?>
