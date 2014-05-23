<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Campaign\Form;

use Pi;
use Pi\Form\Form as BaseForm;

class RegisterForm  extends BaseForm
{
    public function __construct($name = null, $option = array())
    {
        parent::__construct($name);
    }

    public function init()
    {
        // first_name
        $this->add(array(
            'name' => 'first_name',
            'options' => array(
                'label' => __('First name'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                'required'  => true,
            )
        ));
        // last_name
        $this->add(array(
            'name' => 'last_name',
            'options' => array(
                'label' => __('Last name'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                'required'  => true,
            )
        ));
        // email
        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => __('Email'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
                'required'  => true,
            )
        ));
        // mobile
        $this->add(array(
            'name' => 'mobile',
            'options' => array(
                'label' => __('Mobile'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));
        /*// website
        $this->add(array(
            'name' => 'website',
            'options' => array(
                'label' => __('Website'),
            ),
            'attributes' => array(
                'type' => 'text',
                'description' => '',
            )
        ));*/
        // Image
        $this->add(array(
            'name' => 'image',
            'options' => array(
                'label' => __('Image'),
            ),
            'attributes' => array(
                'type' => 'file',
                'description' => '',
                'required'  => true,
            )
        ));
        // Save
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => __('Submit'),
            )
        ));
    }
}