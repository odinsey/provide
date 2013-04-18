<?php

namespace NP\Bundle\ModuloBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PictureFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('title', 'text', array('required'=>false))
			->add('file', null, array('required' => false));
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
