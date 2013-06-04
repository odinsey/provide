<?php

namespace NP\Bundle\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cms\Bundle\AdminBundle\Controller\AdminDashboardController as BaseAdminDashboardController;

class AdminDashboardController extends BaseAdminDashboardController {

    /**
     * @Template("NPAdminBundle:AdminDashboard:index.html.twig")
     */
    public function indexAction() {

        return array();
    }

}
