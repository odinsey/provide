<?php

namespace NP\Bundle\ModuloBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GalleryFormType extends AbstractType {

	private $isGranted;

	public function __construct($roleFlag) {
		$this->isGranted = $roleFlag;
	}

	public function buildForm(FormBuilderInterface $builder,array $options) {
		$builder->add('title',null,array('label'=>'Nom'));
		if($this->isGranted){
			$builder->add('published',null,array('label'=>'Publié','required'=>false));
		}
		$builder->add('description','richeditor',array('label'=>'Description'))
				->add('pictures','picture_collection',array(
					'label'=>'Photos',
					'type'=>new PictureFormType(),
					'allow_add'=>true,
					'allow_delete'=>true,
					'by_reference'=>false,
					'attr'=>array('class'=>'entity-collections sortable'),
					//label for each team form type
					'options'=>array(
						'attr'=>array('class'=>'entity-collection')
					))
		);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class'=>'NP\Bundle\ModuloBundle\Entity\Gallery',
			'cascade_validation'=>true
		));
	}

	public function getName() {
		return 'np_modulo_gallery';
	}

}
