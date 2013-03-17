<?php

namespace NP\Bundle\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NP\Bundle\EventBundle\Form\Type\PictureFormType;

class StepFormType extends AbstractType {
        private $isGranted;

        public function __construct($roleFlag = false){
            $this->isGranted = $roleFlag;
        }

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder->add('title', null, array('label' => 'Nom'))
                        ->add('date', 'date', array('label' => 'Date'))
			->add('description', 'richeditor', array('label' => 'Description'));

                if($this->isGranted){
                    $builder->add('published', null, array('label' => 'Publié'));
                }
                $builder->add('pictures', 'picture_collection', array(
				'type' => new PictureFormType(),
                                'label' => 'Photos',
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				'attr' => array('class' => 'pictures entity-collections sortable'),
				//label for each team form type
				'options' => array(
					'attr' => array('class' => 'entity-collection')
				))
		);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver){
		$resolver->setDefaults(array(
			'data_class' => 'NP\Bundle\EventBundle\Entity\Step',
			'cascade_validation' => true
		));
	}

	public function getName(){
		return 'np_event_step';
	}
}
