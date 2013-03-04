<?php
namespace NP\Bundle\EventBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class EventGroup {
    /**
     * @Assert\Choice(callback = "getActions")
     */
    public $action;

    public static function getActions()
    {
        return array(
            'none',
            'published',
            'delete'
        );
    }
}