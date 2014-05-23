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
namespace Module\Campaign\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

class PeopleController extends ActionController
{
	public function indexAction()
    {
        // Get info from url
        $id = $this->params('id');
        $module = $this->params('module');
        // Get Module Config
        $config = Pi::service('registry')->config->read($module);
        // Find people
        $people = $this->getModel('people')->find($id);
        $people = Pi::api('people', 'campaign')->canonizePeople($people);
        // Check status
        if (!$people || $people['status'] != 1) {
            $this->jump(array('', 'module' => $module, 'controller' => 'index'), __('This person not found.'));
        }
        // Update Hits
        $this->getModel('people')->increment('hits', array('id' => $people['id']));
        // Set header and title
        $title = sprintf(__('%s %s supports us'), $people['first_name'], $people['last_name']);
        $seoTitle = Pi::api('text', 'campaign')->title($title);
        $seoDescription = Pi::api('text', 'campaign')->description($title);
        $seoKeywords = Pi::api('text', 'campaign')->keywords($title);
        // Set view
        $this->view()->headTitle($seoTitle);
        $this->view()->headDescription($seoDescription, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('campaign_people');
        $this->view()->assign('people', $people);
        $this->view()->assign('config', $config);      
    }
}