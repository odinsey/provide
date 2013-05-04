<?php

namespace NP\Bundle\ModuloBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResourcesFormType extends AbstractType {

	private $isGranted;

	public function __construct($roleFlag) {
		$this->isGranted = $roleFlag;
	}

	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		$builder->addEventSubscriber(new RessourceFieldSubscriber($this->isGranted));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'NP\Bundle\ModuloBundle\Entity\Resources',
			'cascade_validation' => true
		));
	}

	public function getName() {
		return 'np_modulo_resources';
	}

}
