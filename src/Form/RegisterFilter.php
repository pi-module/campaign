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
use Zend\InputFilter\InputFilter;

class RegisterFilter extends InputFilter
{
    public function __construct()
    {
        // first_name
        $this->add(array(
            'name' => 'first_name',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
        ));
        // last_name
        $this->add(array(
            'name' => 'last_name',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
        ));
        // email
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'useMxCheck' => false,
                        'useDeepMxCheck' => false,
                        'useDomainCheck' => false,
                    ),
                ),
                new \Module\System\Validator\UserEmail(array(
                    'backlist' => false,
                    'checkDuplication' => false,
                )),
            ),
        ));
        // mobile
        $this->add(array(
            'name' => 'mobile',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
            'validators'    => array(
                new \Module\Campaign\Validator\MobileValidation,
            ),
        ));
        /*// website
        $this->add(array(
            'name' => 'website',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StringTrim',
                ),
            ),
        ));*/
        // image
        $this->add(array(
            'name' => 'image',
            'required' => false,
        ));
    }
}    	