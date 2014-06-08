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
namespace Module\Campaign\Block;

use Pi;
use Zend\Db\Sql\Predicate\Expression;

class Block
{ 
    public static function people($options = array(), $module = null)
    {
        // Set options
        $list = array();
        $block = array();
        $block = array_merge($block, $options);
        // Set info
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($block['number']);
        $where = array('status' => 1);
        // Get random ads for mobile
        $select = Pi::model('people', $module)->select()->where($where)->order($order)->limit($limit);
        $rowset = Pi::model('people', $module)->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = Pi::api('people', 'campaign')->canonizePeople($row);
        }
        // Set block array
        $block['resources'] = $list;
        return $block;
    }
}