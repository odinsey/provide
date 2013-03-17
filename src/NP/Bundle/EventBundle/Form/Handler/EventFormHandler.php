<?php

namespace NP\Bundle\EventBundle\Form\Handler;

use NP\Bundle\CoreBundle\Form\Handler\BaseFormHandler;
use Symfony\Component\Form\Form;

class EventFormHandler extends BaseFormHandler {
    protected $class_name = 'NP\Bundle\EventBundle\Entity\Event';
    
    protected function preSave(Form $form, $entity, $controller) {
        $form->getData()->setUpdatedAt(new \Datetime());
    }

}
