<?php
    class UsersController extends AppController{
        public $name = 'Users';
        public $layout = 'kokosupo';
        public $uses = array('User');
        public $components = array(
            'DebugKit.Toolbar',
            'TwitterKit.Twitter',
            'Auth' => array(
                'authenticate'   => array(
                    'Form' => array(
                        'userModel' => 'User'
                    ),
                ),
                'loginRedirect'  => array('controller' => 'Kokosupos', 'action' => 'index'),
                'logoutRedirect' => array('controller' => 'Kokosupos', 'action' => 'login'),
                'loginAction'    => array('controller' => 'Kokosupos', 'action' => 'login'),
                'authError'      => 'ログインしてください',
            )
        );

        public function index(){
            if($this->request->is('post')){
                //debug($this->request);
                if($this->Auth->login()){
                    //$this->Session->delete('Auth.redirect');
                    return $this->redirect($this->Auth->loginRedirect);
                } else{
                    $this->Session->setFlash(__('ユーザ名かパスワードが違います'), 'default', array(), 'auth');
                }
            }
        }

        public function login(){
            if($this->request->is('post')){
                //debug($this->request);
                if($this->Auth->login()){
                    //$this->Session->delete('Auth.redirect');
                    return $this->redirect($this->Auth->loginRedirect);
                } else{
                    $this->Session->setFlash(__('ユーザ名かパスワードが違います'), 'default', array(), 'auth');
                }
            }
        }
    }
