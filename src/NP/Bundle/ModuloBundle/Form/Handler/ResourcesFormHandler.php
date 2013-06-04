<?php

namespace NP\Bundle\ModuloBundle\Form\Handler;

use Cms\Bundle\AdminBundle\Form\Handler\BaseEntityFormHandler;

class ResourcesFormHandler extends BaseEntityFormHandler {
    protected $class_name = 'NP\Bundle\ModuloBundle\Entity\Resources';

    protected function postSave(FormInterface $form, ContainerAwareInterface $controller) {
        if( !$controller->get('security.context')->isGranted('ROLE_SUPER_ADMIN') ){
            $form->getData()->setPublished(false);
        }
    }
}