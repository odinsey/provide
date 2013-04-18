<?php

namespace NP\Bundle\AdminBundle\Form\Extension\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class FileCollectionType extends AbstractType {


	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder,array $options) {

	}

	/**
	 * {@inheritdoc}
	 */
	public function buildView(FormView $view,FormInterface $form,array $options) {

	}

	public function getParent() {
		return 'collection';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return 'file_collection';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDefaultOptions(array $options) {
		return array();
	}

}