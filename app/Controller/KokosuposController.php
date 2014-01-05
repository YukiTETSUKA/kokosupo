<?php
    class KokosuposController extends AppController{
       public $name = 'Kokosupos';
       public $layout = 'kokosupo';
       public $uses = array('User');
       public $components = array(
           'DebugKit.Toolbar',
           'TwitterKit.Twitter',
           'Auth' => array(
               'loginRedirect'  => array('action' => 'index'),
               'logoutRedirect' => array('action' => 'login'),
               'loginAction'    => array('action' => 'login'),
               'authError'      => 'ログインしてください',
           )
       );

       public function beforeFilter(){
           $this->Auth->allow('login', 'logout', 'sign_up', 'twitter_login', 'twitter_callback', 'facebook_login', 'facebook_callback');
           $user = $this->Auth->user();
           $this->set('user', $user);
       }

       public function index(){
       }

       public function login(){
       }

       public function sign_up(){
       }

       public function twitter_login(){
           return $this->Redirect($this->Twitter->getAuthenticateUrl(null, true));
       }

       public function twitter_callback(){
           if(!$this->Twitter->isRequested()){
               $this->flash(__('invalid access.'), '/', 5);
               return;
           }

           $this->Twitter->setTwitterSource('twitter');
           $token = $this->Twitter->getAccessToken();
           $data = $this->User->twitter_sign_up($token);

           if(isset($data['name'])){
               $this->Auth->login($data);
           } else{
               $this->Session->setFlash(__('既にその名前は使用されています'));
           }

           return $this->Redirect(array('action' => 'index'));
       }

       public function facebook_login(){
       }

       public function facebook_callback(){
       }

       public function logout(){
           $this->Auth->logout();
           $this->Session->destroy();
           $this->Session->setFlash(__('ログアウトしました'));
           $this->redirect(array('action' => 'login'));
       }
    }
