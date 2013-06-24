<?php

namespace NP\Bundle\ModuloBundle\Controller;

use NP\Bundle\AdminBundle\Controller\BaseAdminController;

class EventController extends BaseAdminController {

    public $doctrine_namespace = "NPModuloBundle:Event";
    protected $route_archive = "np_modulo_admin_event_archive";
    protected $template_menuleft = 'NPModulo:Event:menuleft.html.twig';
	
    protected $default_render_parameters = array(
	    'translation_prefix',
	    'bundle_name',
	    'route_new',
	    'route_index',
	    'route_archive',
	    'route_edit',
	    'route_show',
	    'route_delete',
	    'template_menuleft',
	    'template_index',
	    'template_new',
	    'template_edit',
	    'template_show',
	    'template_menuleft'
    );
    
    protected function retrieveEntityList() {
	return $this->getDoctrine()
                         ->getManager()
                         ->getRepository('NPModuloBundle:Event')
                         ->findAllInScholarYear();
    }

    protected function retrieveArchiveList() {
	return $this->getDoctrine()
                         ->getManager()
                         ->getRepository('NPModuloBundle:Event')
                         ->findAllArchives();
    }
    
    public function archiveAction() {
	    $form = $this->getGroupForm(new $this->group_object_name());

	    $request = $this->getRequest();

	    $filter_entity = (class_exists($this->filter_object_name)) ? new $this->filter_object_name() : null;
	    $filter = $this->getFilterForm($filter_entity);

	    $query = $this->retrieveArchiveList();

	    $pagination = $this->get('knp_paginator')
			    ->paginate($query, $request->query->get('page', 1), $this->max_per_page);

	    return $this->render($this->template_index, array(
				    'filter' => (($filter) ? $filter->createView() : null),
				    'pagination' => $pagination,
				    'groupForm' => $form->createView(),
				    'route_form_action' => $this->route_group_process,
	    ));
    }
}