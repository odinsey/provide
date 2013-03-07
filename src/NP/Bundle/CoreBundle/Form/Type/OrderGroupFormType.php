<?php

namespace NP\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderGroupFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('action', 'hidden', array(
            'data'   => 'order'
        ));
    }

    public function getName()
    {
        return 'np_gallery_group';
    }
}