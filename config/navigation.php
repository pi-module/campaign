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
    'front'   => array(
        'register' => array(
            'label'         => _a('Register'),
            'permission'    => array(
                'resource'  => 'public',
            ),
            'route'         => 'campaign',
            'module'        => 'campaign',
            'controller'    => 'register',
        ),
    ),
    'admin' => array(
        'list' => array(
            'label'         => _a('List'),
            'permission'    => array(
                'resource'  => 'list',
            ),
            'route'         => 'admin',
            'module'        => 'campaign',
            'controller'    => 'list',
            'action'        => 'index',
        ),
    ),
);