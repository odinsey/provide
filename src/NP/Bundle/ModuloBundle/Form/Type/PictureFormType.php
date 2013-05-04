<?php

namespace NP\Bundle\ModuloBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PictureFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('position', 'hidden', array('required' => false));
		
		$builder->addEventSubscriber(new PictureFieldSubscriber());
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'NP\Bundle\ModuloBundle\Entity\Picture'
		));
	}

	public function getName() {
		return 'np_modulo_picture';
	}

}
