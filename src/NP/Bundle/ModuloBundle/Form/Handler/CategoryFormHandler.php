<?php

namespace NP\Bundle\ModuloBundle\Form\Handler;

use Cms\Bundle\AdminBundle\Form\Handler\BaseEntityFormHandler;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class CategoryFormHandler extends BaseEntityFormHandler {

    protected $class_name = 'NP\Bundle\ModuloBundle\Entity\Category';

    protected function postSave(FormInterface $form, ContainerAwareInterface $controller) {
        if( !$controller->get('security.context')->isGranted('ROLE_SUPER_ADMIN') ){
            $form->getData()->setPublished(false);
            $fields = array('title'=>'title','description'=>'description','resources'=>'resources');

            $message = \Swift_Message::newInstance()
                    ->setSubject('['.$_SERVER['HTTP_HOST'].'] - Modération de contenu')
                    ->setFrom('root@localhost')
                    ->setTo('nicolas.pajon@gmail.com')
                    ->setBody(
                            $controller->renderView(
                                    'NPModuloBundle::email.html.twig', array(
                                        'title' => '['.$_SERVER['HTTP_HOST'].'] - Modération de contenu',
                                        'entity' => $form->getData(),
                                        'fields' => $fields,
                                        'route_edit' => 'np_modulo_admin_category_edit'
                                    )
                            ), 'text/html', 'utf-8'
                    );
            $controller->get('mailer')->send($message);
        }
    }

}