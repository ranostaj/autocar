<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{



    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if($this->Auth->user()){
            $this->set('auth',$this->Auth->user());
        }
    }

    public function initialize()
    {

        parent::initialize();
        $this->viewBuilder()->layout('application');
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Header');
        $this->loadComponent('Paginator');

        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            'loginRedirect' => [
                'controller' => 'Application',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
            'authorize' => 'Controller',
        ]);

    }


    public function isAuthorized($user)
    {
        return true;
    }

    public function isAdmin()
    {

        return $this->Auth->user('role') == 'admin' ? true : false;
    }

    public function getUserId()
    {
        return $this->Auth->user('id');
    }
}
