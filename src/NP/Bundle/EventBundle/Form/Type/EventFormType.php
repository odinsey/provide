<?php

namespace NP\Bundle\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NP\Bundle\GalleryBundle\Form\Type\PictureFormType;

class EventFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('title', null, array('label' => 'Nom'))
			->add('description', 'richeditor', array('label' => 'Description'))
			->add('published', null, array('label' => 'Publié'))
			->add('pictures', 'picture_collection', array(
				'type' => new PictureFormType(),
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
