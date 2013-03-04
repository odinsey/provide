<?php

namespace NP\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('username', null, array('label' => 'Nom'))
			->add('email', null, array('label' => 'Courriel'))
			->add('plainPassword', null, array('label' => 'Mot de passe'))
			->add('roles', 'choice', array(
			    'label' => 'Permissions',
			    'choices'   => array(				
				'ROLE_USER'=>'Rédacteur',
				'ROLE_ADMIN'=>'Proviseur'
			    ),
			    'expanded'=>true,
			    'multiple'=>true,
			    'empty_value' => true
			    ));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'NP\Bundle\CoreBundle\Entity\User',
			'cascade_validation' => true
		));
	}

	public function getName(){
		return 'np_core_user';
	}
}
