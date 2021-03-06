<?php

namespace NP\Bundle\ModuloBundle\Controller;

use NP\Bundle\AdminBundle\Controller\BaseAdminController;

class NewsController extends BaseAdminController {

	public $doctrine_namespace = "NPModuloBundle:News";
	protected $template_edit = 'NPModuloBundle:CRUD:edit_actu.html.twig';
	protected $template_index = 'NPModuloBundle:News:index_custom.html.twig';

	protected function retrieveEntityList() {
		return $this->getClassRepository()->findBy(array(), array('id' => 'DESC'));
	}
}
