<?php

namespace NP\Bundle\ModuloBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResourcesFormType extends AbstractType {
        private $isGranted;

        public function __construct($roleFlag){
            $this->isGranted = $roleFlag;
        }

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('title', null, array('label' => 'Nom'))
			->add('description', 'richeditor');
                if($this->isGranted){
                    $builder->add('published', null, array('required'=>false));
                }
                $builder->add('file');
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'NP\Bundle\ModuloBundle\Entity\Resources',
			'cascade_validation' => true
		));
	}

	public function getName(){
		return 'np_modulo_resources';
	}
}
