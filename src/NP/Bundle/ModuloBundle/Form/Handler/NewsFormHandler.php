<?php

namespace NP\Bundle\ModuloBundle\Form\Handler;

use Cms\Bundle\AdminBundle\Form\Handler\BaseEntityFormHandler;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class NewsFormHandler extends BaseEntityFormHandler {
    protected $class_name = 'NP\Bundle\ModuloBundle\Entity\News';

    protected function postSave(FormInterface $form, ContainerAwareInterface $controller) {
        if( !$controller->get('security.context')->isGranted('ROLE_SUPER_ADMIN') ){
	    $admins = $controller->get('fos_user.user_manager')->findUsers();
	    $mails = array();
	    foreach( $admins as $admin ){
		if( in_array('ROLE_SUPER_ADMIN', $admin->getRoles() ) ){
		    $mails[] = $admin->getEmail();
		}
	    }
            $form->getData()->setPublished(false);
	    
            $fields = array('title'=>'title','description'=>'description','pictures'=>'pictures');
            $message = \Swift_Message::newInstance()
                    ->setSubject('Modération de contenu')
                    ->setFrom('root@localhost')
		    ->setTo($mails)
                    ->setBody(
                            $controller->renderView(
                                    'NPModuloBundle::email.html.twig', array(
                                        'title' => 'Modération de contenu',
					'user' => $controller->get('security.context')->getToken()->getUser()->getUsername(),
                                        'entity' => $form->getData(),
                                        'fields' => $fields,
                                        'route_edit' => 'np_modulo_admin_news_edit'
                                    )
                            ), 'text/html', 'utf-8'
                    );
            $controller->get('mailer')->send($message);
        }
    }

}