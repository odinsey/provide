<?php

namespace NP\Bundle\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NP\Bundle\EventBundle\Form\Type\StepFormType;
use NP\Bundle\EventBundle\Enum\StatusEnum;

class EventFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options){
            $choices = array(''=>'');
            foreach (StatusEnum::getValues() as $action) {
                $choices[$action] = 'event.form.status.'.$action;
            }

		$builder->add('title', null, array('label' => 'Nom'))
			->add('description', 'richeditor', array('label' => 'Description'))
			->add('file', 'file', array('label' => 'Programme','required'=>false))
			->add('state', 'choice', array('choices' => $choices, 'label' => 'Statut'))
			->add('start', 'date', array('label' => 'Début'))
			->add('stop', 'date', array('label' => 'Fin'))
			->add('published', null, array('label' => 'Publié'))
			->add('steps', 'collection', array(
				'type' => new StepFormType(),
                                'label' => 'Etapes',
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

	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'NP\Bundle\EventBundle\Entity\Event',
			'cascade_validation' => true
		));
	}

	public function getName(){
		return 'np_event_event';
	}
}
