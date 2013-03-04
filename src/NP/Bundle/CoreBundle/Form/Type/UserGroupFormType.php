<?php

namespace NP\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class UserGroupFormType extends AbstractType
{
    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('action', 'choice', array(
            'choices'   => array(
                'none'   => '',
                'delete' => $this->translator->trans('global.form_action.group.delete', array(), 'NPCoreBundle')
            ),
            'multiple'  => false,
            'attr' => array('class' => 'medium')
        ));
    }

    public function getName()
    {
        return 'np_user_group';
    }
}