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
 * Pi::api('mail', 'campaign')->sendInfo($url, $first_name, $last_name, $email);
 * Pi::api('mail', 'campaign')->sendConfirm($id, $code, $first_name, $last_name, $email);
 */

class Mail extends AbstractApi
{
    public function sendInfo($url, $first_name, $last_name, $email)
    {
        // Set to
        $to = array(
            $email => sprintf('%s %s',$first_name, $last_name),
        );
        // Set array
        $info = array(
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'url'         => $url,
        );
        // Set template
        $data = Pi::service('mail')->template('info', $info);
        // Set message
        $message = Pi::service('mail')->message($data['subject'], $data['body'], $data['format']);
        $message->addTo($to);
        $message->setEncoding("UTF-8");
        // Send mail
        Pi::service('mail')->send($message);
    }

    public function sendConfirm($id, $code, $first_name, $last_name, $email)
    {
    	// Set url
    	$url = Pi::url(Pi::service('url')->assemble('campaign', array(
            'module'        => $this->getModule(),
            'controller'    => 'register',
            'action'        => 'confirm',
            'id'            => $id,
            'code'          => $code,
        )));
        // Set to
        $to = array(
            $email => sprintf('%s %s',$first_name, $last_name),
        );
        // Set array
        $confirm = array(
        	'first_name'  => $first_name,
        	'last_name'   => $last_name,
        	'url'         => $url,
        );
        // Set template
        $data = Pi::service('mail')->template('confirm', $confirm);
        // Set message
        $message = Pi::service('mail')->message($data['subject'], $data['body'], $data['format']);
        $message->addTo($to);
        $message->setEncoding("UTF-8");
        // Send mail
        Pi::service('mail')->send($message);
    }
}