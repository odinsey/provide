<?php

namespace NP\Bundle\AdminBundle\Controller;

use Cms\Bundle\AdminBundle\Controller\BaseAdminController as CmsBaseAdminController;
use Cms\Bundle\AdminBundle\Controller\Traits\PublishableControllerTrait;
use Cms\Bundle\AdminBundle\Controller\Traits\SortableControllerTrait;

class BaseAdminController extends CmsBaseAdminController {

	protected function getForm($entity) {
		return $this->createForm(
			new $this->form_type_name($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')),$entity
		);
	}

	protected function buildController() {
		parent::buildController();

		$this->route_publish = ($this->route_publish != 'cms_foo_admin_foo_publish_toggle')
				? $this->route_publish
				: $this->route_prefix . '_' . $this->translation_prefix . '_publish_toggle';


		$class_name = substr($this->doctrine_namespace, strpos($this->doctrine_namespace, ':') + 1);

		$this->route_order = ($this->route_order != 'cms_foo_admin_foo_order')
				? $this->route_order
				: $this->route_prefix . '_' . $this->translation_prefix . '_order';

		if (!$this->get('templating')->exists($this->template_order)) {
			$template_order = $this->bundle_name . ':Admin' . $class_name . ':order.html.twig';
			$this->template_order = $this->get('templating')->exists($template_order) ? $template_order : $this->default_template_order;
		}

		$this->addDefaultRenderParameter('route_publish');
		$this->addDefaultRenderParameter('route_order');
		$this->addDefaultRenderParameter('template_order');
	}

	use SortableControllerTrait;
	use PublishableControllerTrait;
}
?>
