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
namespace Module\Campaign\Validator;

use Pi;
use Zend\Validator\AbstractValidator;

class MobileValidation extends AbstractValidator
{
    const TAKEN        = 'MobileInvalid';

    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::TAKEN     => 'Mobile nubmer is not valid, vlaid example is : 09125556677',
    );

    public function isValid($value)
    {
        $this->setValue($value);
        
        if (!is_numeric($value)) {
            $this->error(static::TAKEN);
            return false;
        }
        
        if (strlen($value) != 11) {
            $this->error(static::TAKEN);
            return false;
        }

        return true;
    }
}
