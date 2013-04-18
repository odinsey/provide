<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use NP\Bundle\ModuloBundle\Service\UploadService;
use Symfony\Component\HttpFoundation\File\File;

class UploadSubscriber implements EventSubscriber {

    protected $upload_service;

    /**
     * Constructor
     *
     */
    public function __construct(UploadService $upload_service) {
        $this->upload_service = $upload_service;
    }

    public function getSubscribedEvents() {
        return array(
            Events::postPersist,
            Events::preUpdate,
            Events::postRemove
        );
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getEntity();
        if ($entity instanceof Picture) {
            if ($entity->getFile() instanceof File) {
                $this->upload_service->uploadFile($entity->getWebPath(), $entity->getFile());
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if ($entity instanceof Picture) {
            $entity->buildPath();
            $args->getEntityManager()->persist($entity);
            $args->getEntityManager()->flush();
            if ($entity->getFile() instanceof File) {
                $this->upload_service->uploadFile($entity->getWebPath(), $entity->getFile());
            }
        }
    }

    public function postRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if ($entity instanceof Picture) {
            if ($entity->getFile() instanceof File) {
                $this->upload_service->removeFile($entity->getWebPath());
            }
        }
    }
}

?>
