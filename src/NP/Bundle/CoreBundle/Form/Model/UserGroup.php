<?php
namespace NP\Bundle\CoreBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UserGroup {
    /**
     * @Assert\Choice(callback = "getActions")
     */
    public $action;
    
    public static function getActions()
    {
        return array(
            'none',
            'delete'
        );
    }
}