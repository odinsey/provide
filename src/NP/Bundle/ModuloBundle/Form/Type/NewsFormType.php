<?php

namespace NP\Bundle\ModuloBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NP\Bundle\ModuloBundle\Form\Type\PictureFormType;

class NewsFormType extends AbstractType {

	private $isGranted;

	public function __construct($roleFlag) {
		$this->isGranted = $roleFlag;
	}

	public function buildForm(FormBuilderInterface $builder,array $options) {
		$builder->add('title')
			->add('description','richeditor');
		if($this->isGranted){
			$builder->add('published',null,array('required'=>false));
		}
		$builder->add('pictures','picture_collection',array(
			'type'=>new PictureFormType($this->isGranted),
			'allow_add'=>true,
			'allow_delete'=>true,
			'by_reference'=>false,
			'attr'=>array('class'=>'entity-collections sortable'),
			//label for each team form typeretarque
			'options'=>array(
				'attr'=>array('class'=>'entity-collection')
			))
		);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class'=>'NP\Bundle\ModuloBundle\Entity\News',
			'cascade_validation'=>true
		));
	}

	public function getName() {
		return 'np_modulo_news';
	}

}