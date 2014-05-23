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
namespace Module\Campaign\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

/*
 * Pi::api('people', 'campaign')->canonizePeople($people);
 */

class People extends AbstractApi
{
    public function canonizePeople($people)
    {
        // Check
        if (empty($people)) {
            return '';
        }
        // Get config
        $config = Pi::service('registry')->config->read($this->getModule());
        // boject to array
        $people = $people->toArray();
        // Set times
        $people['time_create_view'] = _date($people['time_create']);
        $people['time_update_view'] = _date($people['time_update']);
        // Set people url
        $people['peopleUrl'] = pi::url(Pi::service('url')->assemble('campaign', array(
            'module'        => $this->getModule(),
            'controller'    => 'people',
            'id'            => $people['id'],
        )));
        // Set image url
        if ($people['image']) {
            // Set image original url
            $people['originalUrl'] = Pi::url(
                sprintf('upload/%s/original/%s/%s', 
                    $config['image_path'], 
                    $people['path'], 
                    $people['image']
                ));
            // Set image large url
            $people['largeUrl'] = Pi::url(
                sprintf('upload/%s/large/%s/%s', 
                    $config['image_path'], 
                    $people['path'], 
                    $people['image']
                ));
            // Set image medium url
            $people['mediumUrl'] = Pi::url(
                sprintf('upload/%s/medium/%s/%s', 
                    $config['image_path'], 
                    $people['path'], 
                    $people['image']
                ));
            // Set image thumb url
            $people['thumbUrl'] = Pi::url(
                sprintf('upload/%s/thumb/%s/%s', 
                    $config['image_path'], 
                    $people['path'], 
                    $people['image']
                ));
        }
        // return people
        return $people; 
    }
}