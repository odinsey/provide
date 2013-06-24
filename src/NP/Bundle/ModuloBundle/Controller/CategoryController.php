<?php

namespace NP\Bundle\ModuloBundle\Controller;

use NP\Bundle\AdminBundle\Controller\BaseAdminController;

class CategoryController extends BaseAdminController {

    public $doctrine_namespace = "NPModuloBundle:Category";
    
    protected function retrieveEntityList() {
	return $this->getClassRepository()->findBy(array(), array('id' => 'DESC'));
    }
}
