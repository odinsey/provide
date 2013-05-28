<?php
namespace NP\Bundle\ModuloBundle\Entity;

use Doctrine\Common\EventListener;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\Security\Core\SecurityContext;
/**
 * Description of StepListener
 *
 * @author nicolas
 */
class PublishableListener {
    
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
	$em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
	$securityContext = $this->container->get('security.context');
                            
	if( !$securityContext->getToken()->getUser()->hasRole('ROLE_SUPER_ADMIN') ){	    
	    foreach ($uow->getScheduledEntityInsertions() AS $entity) {
		var_dump(get_class($entity));
	    }

	    foreach ($uow->getScheduledEntityUpdates() AS $entity) {
		if(method_exists($entity,'setPublished')){
		    $entity->setPublished(false);
		}
	    }

	    foreach ($uow->getScheduledEntityDeletions() AS $entity) {
		var_dump(get_class($entity));
	    }

	    foreach ($uow->getScheduledCollectionDeletions() AS $col) {
		var_dump(get_class($entity));
	    }

	    foreach ($uow->getScheduledCollectionUpdates() AS $col) {
		var_dump(get_class($entity));
	    }	        
	}
    }
}

?>
