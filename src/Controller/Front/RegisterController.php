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
use Pi\File\Transfer\Upload;
use Module\Campaign\Form\RegisterForm;
use Module\Campaign\Form\RegisterFilter;
use Zend\Math\Rand;

class RegisterController extends ActionController
{
    /**
     * Image Prefix
     */
    protected $ImagePrefix = 'people_';

    /**
     * Category Columns
     */
    protected $peopleColumns = array(
        'id', 'uid', 'first_name', 'last_name', 'email', 'mobile', 'website', 
        'image', 'path', 'status', 'time_create', 'time_update', 'hits', 'code'
    );

    /**
     * index Action
     */
    public function indexAction()
    {
        // Get id
        $module = $this->params('module');
        // Set form
        $form = new RegisterForm('register');
        $form->setAttribute('enctype', 'multipart/form-data');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $file = $this->request->getFiles();
            $form->setInputFilter(new RegisterFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                // upload image
                if (!empty($file['image']['name'])) {
                    // Set upload path
                    $values['path'] = sprintf('%s/%s', date('Y'), date('m'));
                    $originalPath = Pi::path(sprintf('upload/%s/original/%s', $this->config('image_path'), $values['path']));
                    // Upload
                    $uploader = new Upload;
                    $uploader->setDestination($originalPath);
                    $uploader->setRename($this->ImagePrefix . '%random%');
                    $uploader->setExtension($this->config('image_extension'));
                    $uploader->setSize($this->config('image_size'));
                    if ($uploader->isValid()) {
                        $uploader->receive();
                        // Get image name
                        $values['image'] = $uploader->getUploaded('image');
                        // process image
                        Pi::api('image', 'campaign')->process($values['image'], $values['path']);
                    } else {
                        $this->jump(array('action' => 'update'), __('Problem in upload image. please try again'));
                    }
                } elseif (!isset($values['image'])) {
                    $values['image'] = '';  
                }
                // Set just category fields
                foreach (array_keys($values) as $key) {
                    if (!in_array($key, $this->peopleColumns)) {
                        unset($values[$key]);
                    }
                }
                // Without 0 o
                $code = Rand::getString(12, 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789', true);
                // Set time
                $values['time_create'] = time();
                $values['time_update'] = time();
                $values['status'] = 3;
                $values['code'] = $code;
                $values['uid'] = Pi::user()->getId();
                // Save values
                $row = $this->getModel('people')->createRow();
                $row->assign($values);
                $row->save();
                // Mail
                Pi::api('mail', 'campaign')->sendConfirm($row->id, $row->code, $row->first_name, $row->last_name, $row->email);
                // jump
                $message = __('You data saved successfully.');
                $this->jump(array('action' => 'finish'), $message);
            } else {
                $message = __('Invalid data, please check and re-submit.');
            }   
        }
        // Set header and title
        $title = __('Join to campaign');
        $seoTitle = Pi::api('text', 'campaign')->title($title);
        $seoDescription = Pi::api('text', 'campaign')->description($title);
        $seoKeywords = Pi::api('text', 'campaign')->keywords($title);
        // Set view
        $this->view()->headTitle($seoTitle);
        $this->view()->headDescription($seoDescription, 'set');
        $this->view()->headKeywords($seoKeywords, 'set');
        $this->view()->setTemplate('campaign_register');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Join to campaign'));
    }

    public function finishAction()
    {
        $this->view()->setTemplate('campaign_finish');
    }

    public function confirmAction()
    {
        // Get info from url
        $id = $this->params('id');
        $code = $this->params('code');
        $module = $this->params('module');
        // Get Module Config
        $config = Pi::service('registry')->config->read($module);
        // Find people
        $people = $this->getModel('people')->find($id);
        $people = Pi::api('people', 'campaign')->canonizePeople($people);
        // Check people
        if (!$people || empty($people)) {
            $this->jump(array('', 'module' => $module, 'controller' => 'index'), __('This person not found.'));
        }
        // Check status
        if ($people['status'] != 3) {
            $this->jump(array('', 'module' => $module, 'controller' => 'index'), __('You confirm your information before this time'));
        }
        // Check code
        if ($people['code'] != $code) {
                $this->jump(array('', 'module' => $module, 'controller' => 'index'), __('Your code is not true.'));
        }
        // confirm
        $this->getModel('people')->update(array('status' => 2), array('id' => $people['id']));
        // Go to user page
        $this->view()->setTemplate('campaign_confirm');
    }
}