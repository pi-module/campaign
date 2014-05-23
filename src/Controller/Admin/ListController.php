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
namespace Module\Campaign\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Zend\Db\Sql\Predicate\Expression;

class ListController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        $status = $this->params('status', 1);
        // Set info
        $list = array();
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($this->config('admin_perpage'));
        $where = array('status' => $status);
        // Get list of story
        $select = $this->getModel('people')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('people')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = Pi::api('people', 'campaign')->canonizePeople($row);
        }
        // get count     
        $columns = array('count' => new Expression('count(*)'));
        $select = $this->getModel('people')->select()->where($where)->columns($columns);
        $count = $this->getModel('people')->selectWith($select)->current()->count;
        // paginator
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage(intval($this->config('admin_perpage')));
        $paginator->setCurrentPageNumber(intval($page));
        $paginator->setUrlOptions(array(
            'router'    => $this->getEvent()->getRouter(),
            'route'     => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params'    => array_filter(array(
                'module'        => $this->getModule(),
                'controller'    => 'list',
                'action'        => 'index',
                'status'        => $status,
            )),
        ));
        // Set view
        $this->view()->setTemplate('list_index');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('status', $status);
    }

    public function acceptAction()
    {
        // Get id and status
        $id = $this->params('id');
        $status = $this->params('status');
        $return = array();
        // set people
        $people = $this->getModel('people')->find($id);
        // Check
        if ($people && in_array($status, array(1, 2, 3, 4, 5))) {
            // Accept
            $people->status = $status;
            // Save
            if ($people->save()) {
                if ($status == 1) {
                    // Set url
                    $url = Pi::url($this->url('campaign', array(
                        'module'        => $this->getModule(),
                        'controller'    => 'people',
                        'id'            => $people->id,
                    )));
                    Pi::api('mail', 'campaign')->sendInfo($url, $people->first_name, $people->last_name);
                    Pi::api('sitemap', 'sitemap')->add('campaign', 'people', $people->id, $url);
                }
                $return['message'] = sprintf(__('%s status update successfully'), $people->id);
                $return['ajaxstatus'] = 1;
                $return['id'] = $people->id;
                $return['storystatus'] = $people->status;
            } else {
                $return['message'] = sprintf(__('Error in update %s'), $people->id);
                $return['ajaxstatus'] = 0;
                $return['id'] = 0;
                $return['storystatus'] = $people->status;
            }
        } else {
            $return['message'] = __('Please select people');
            $return['ajaxstatus'] = 0;
            $return['id'] = 0;
            $return['storystatus'] = 0;
        }
        return $return;
    }
}