<?php

namespace NP\Bundle\AdminBundle\Form\Extension\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Util\PropertyPath;

class CustomfileType extends AbstractType {


	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder,array $options) {

	}

        /**
         * Passe l'url du fichier à la vue
         *
         * @param \Symfony\Component\Form\FormView $view
         * @param \Symfony\Component\Form\FormInterface $form
         * @param array $options
         */
        public function buildView(FormView $view, FormInterface $form, array $options)
        {
            if (array_key_exists('filepath', $options)) {
                $parentData = $form->getData();
                $propertyPath = new PropertyPath($options['filepath']);
                $filepath = $propertyPath->getValue($parentData);
                // définit une variable "path" qui sera disponible à l'affichage du champ
                $view->vars['filepath'] = $filepath;
            }elseif( $vars = $view->getParent()->getVars() ){
                $view->vars['filepath'] = $vars['value']->getUrl();
            }else{
                $view->vars['filepath'] = null;
            }
        }

	public function getParent() {
		return 'file';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return 'customfile';
	}

        /**
         * Ajoute l'option image_path
         *
         * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
         */
        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $resolver->setOptional(array('filepath'));
        }

	/**
	 * {@inheritdoc}
	 */
	public function getDefaultOptions(array $options) {
		return array('filepath');
	}

}