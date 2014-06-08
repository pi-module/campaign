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
    // Admin section
    'admin' => array(
        array(
            'title'         => _a('List'),
            'controller'    => 'list',
            'permission'    => 'list',
        ),
    ),
    // Front section
    'front' => array(
        array(
            'title'         => _a('Index page'),
            'controller'    => 'index',
            'permission'    => 'public',
            'block'         => 1,
        ),
        array(
            'title'         => _a('People'),
            'controller'    => 'people',
            'permission'    => 'public',
            'block'         => 1,
        ),
        array(
            'title'         => _a('Register'),
            'controller'    => 'register',
            'permission'    => 'public',
            'block'         => 1,
        ),
    ),
);