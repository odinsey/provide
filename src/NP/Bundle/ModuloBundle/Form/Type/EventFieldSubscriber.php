<?php

namespace NP\Bundle\ModuloBundle\Form\Type;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventFieldSubscriber implements EventSubscriberInterface {
	
	private $isGranted;

	public function __construct($roleFlag) {
		$this->isGranted = $roleFlag;
	}
	
	public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // check if the product object is "new"
        // If you didn't pass any data to the form, the data is "null".
        // This should be considered a new "Product"
        $form->add('title')
             ->add('description', 'richeditor');	    
	$form->add('file',$data->getPath()?'customfile':null, array('required' => false));	
        $form->add('start', 'date')
             ->add('stop', 'date');
        if ($this->isGranted) {
            $form->add('published', null, array('required'=>false));
        }

        $form->add('steps', 'collection', array(
            'type' => new StepFormType($this->isGranted),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'attr' => array('class' => 'entity-collections sortable'),
            //label for each team form type
            'options' => array(
                'attr' => array('class' => 'entity-collection')
            ))
        );
    }
}