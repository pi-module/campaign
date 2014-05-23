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
return array(
    // route name
    'campaign'  => array(
        'name'      => 'campaign',
        'type'      => 'Module\Campaign\Route\Campaign',
        'options'   => array(
            'route'     => '/campaign',
            'defaults'  => array(
                'module'        => 'campaign',
                'controller'    => 'index',
                'action'        => 'index'
            )
        ),
    )
);