<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\InternalErrorException;
use Cake\Network\Exception\ForbiddenException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use Cake\Utility\Hash;
use Cake\Utility\Security;



class UsersController extends AppController
{

    public $encryptKey = "798d7asdBfhds897dsadasdas3432423saMNks";

    public function initualize(Event $event)
    {

        $this->loadModel('Users');


    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->layout('ajax');
        $this->Auth->allow(['password', 'forgot']);

    }


    /**
     * Users List
     */
    public function index() {

        $users = $this->Users->find('all');
        $this->set('rows',$users);
        $this->set('_serialize',['rows']);
    }


    /**
     * Users List
     */
    public function remove($id = null) {

        if(!$this->isAdmin())
        {
            throw new ForbiddenException("Nemate prava");
        }

        if($id) {
            $user = $this->Users->get($id);
            $this->Users->delete($user);
        }
        $this->set('_serialize',[]);
    }


    /**
     * Users List
     */
    public function view($id = null) {

        if($id) {
            $user = $this->Users->get($id);
            if(!$user){
                return  $this->Header->setResponse(500,["message"=>"Tento uživateľ neexistuje"]);
            }

            $this->set('user', $user);
            $this->set('_serialize', ['user']);
        }

    }

    /**
     * Edit
     * @param null $id
     */
    public function edit($id = null) {

        if($id) {
            $user = $this->Users->get($id);

            if(!$user){
                return  $this->Header->setResponse(500,["message"=>"Tento uživateľ neexistuje"]);
            } else {

                $this->Users->patchEntity($user,$this->request->data(),['validate' => 'update']);
                if(!$this->Users->save($user)) {
                    $this->response->header('HTTP/1.1', '500 Internal Server Error');
                    foreach ($user->errors() as $key => $error) {
                        foreach ($error as $e) {
                            $err[] = $e;
                        }
                    }

                    $this->set('errors', $err);
                    $this->set('_serialize', ['errors']);
                    return;
                }
            }

            $this->set('user', $user);
            $this->set('_serialize', ['user']);
        }

    }

    /**
     * Save new user
     *
     */
    public function add() {

        if(!$this->isAdmin()) {
            $this->response->header('HTTP/1.1','500 Internal Server Error');
            $this->set('errors',  array("Nemáte práva na vytvorenie užívateľa"));
            $this->set('_serialize', [ 'errors']);
            return;
        }

        $user = $this->Users->newEntity($this->request->data,['validate' => 'create']);

        if(!$this->Users->save($user))
        {
            $this->response->header('HTTP/1.1','500 Internal Server Error');
            foreach($user->errors() as $key=>$error){
                foreach($error as $e) {
                    $err[] =  $e;
                }
            }

            $this->set('errors',  $err);
            $this->set('_serialize', [ 'errors']);
        } else {

            $this->set('user', $user);
            $this->set('_serialize', ['user']);
        }
    }



    /**
     * Save new user
     *
     */
    public function forgot() {

        $username = $this->request->data('username');
        $user = $this->Users->find()
                ->where(['username'=>$this->request->data('username')])
                ->first();

        if(!$user)
        {
            $this->response->header('HTTP/1.1','500 Internal Server Error');
            $err[] = "Užívateľ nebol najdený";
            $this->set('errors',  $err);
            $this->set('_serialize', [ 'errors']);
        } else {


            $user->new_pass = $this->generateRandomString(6);
            $this->Users->save($user);

            $email = new Email();
            $email->emailFormat('html')
                ->template('forgot')
                ->transport('default')
                ->viewVars([
                    'hash'=> sha1($user->new_pass),
                    'password'=>  $user->new_pass
                ])
                ->to($username)
                ->from($username)
                ->subject('Reset hesla -  taznezariadenia.sk')
                ->send();

            $this->set('user', $user->new_pass);
            $this->set('_serialize', ['user']);
        }
    }

    function password($pass) {

        $this->viewBuilder()->layout('default');
        $data = [];

        if($pass) {

            $user = $this->Users->find()
                ->where(['SHA1(new_pass)'=>$pass])
                ->first();

            if($user) {
                $user->password = $user->new_pass;
                $user->new_pass = null;
                $this->Users->save($user);

            } else {

                throw new NotFoundException("Uzivatel nebol najdeny");
            }
        }
        $this->set($data);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    function session()
    {

        $this->set('data',"success");
        $this->set('_serialize', ['data']);

    }
}
