<?php

namespace NP\Bundle\ModuloBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('username', null, array('label' => 'Nom'))
			->add('email', null, array('label' => 'Courriel'))
			->add('plainPassword', null, array('label' => 'Mot de passe', 'required'=>false))
			->add('enabled', null, array('label' => 'Actif', 'required'=>false))
			->add('roles', 'choice', array(
			    'label' => 'Permissions',
			    'choices'   => array(
				'ROLE_ADMIN'=>'Rédacteur',
				'ROLE_SUPER_ADMIN'=>'Proviseur'
			    ),
			    'expanded'=>true,
			    'multiple'=>true,
			    'empty_value' => true
			    ));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'Cms\Bundle\AdminBundle\Entity\User',
			'cascade_validation' => true
		));
	}

	public function getName(){
		return 'np_modulo_user';
	}
}
