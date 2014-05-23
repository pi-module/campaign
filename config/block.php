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
    'people'    => array(
        'title'         => _a('New people'),
        'description'   => _a('New people list'),
        'render'        => 'block::people',
        'template'      => 'people',
        'config'        => array(
            'number'    => array(
                'title' => _a('Number'),
                'description' => '',
                'edit' => 'text',
                'filter' => 'number_int',
                'value' => 40,
            ),
        ),
    ),
);