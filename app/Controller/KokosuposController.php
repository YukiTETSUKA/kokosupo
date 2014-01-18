<?php
    App::import('Vendor','facebook', array('file' => 'facebook'.DS.'src'.DS.'facebook.php')); //sdkのインポート

    class KokosuposController extends AppController{
        public $name = 'Kokosupos';
        public $layout = 'kokosupo';
        public $uses = array('User', 'Spot');
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
            //$this->Auth->allow('login', 'logout', 'sign_up', 'twitter_login', 'twitter_callback', 'facebook_login', 'facebook_callback');
            $user = $this->Auth->user();
            $this->set('user', $user);
        }

        public function index(){
            //debug($this->request);
            if($this->request->is('post')){
               $spots = $this->Spot->search($this->request->data['kokosupo']);
               $this->set('spots', $spots);
               if(isset($this->request->data['kokosupo']['keyword'])){
                   $this->set('keyword', $this->request->data['kokosupo']['keyword']);
               }
            } else{
               $this->set('spots', $this->Spot->find('all', array('order' => array('Spot.id' => 'desc'))));
            }
        }

        public function login(){
            if($this->request->is('post')){
                if($this->Auth->login($this->request->data)){
                    $this->redirect($this->Auth->loginRedirect);
                } else{
                    $this->Session->setFlash(__('ユーザ名かパスワードが違います'), 'default', array(), 'auth');
                }
            }
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

           return $this->Redirect($this->Auth->loginRedirect);
        }

        private function createFacebook(){
           return new Facebook(array(
                'appId' => '715929478430933',
                'secret' => '44ab206186eb05d1802138a12fc0607e'
           ));
        }

        public function facebook_login(){
           $facebook = $this->createFacebook();
           $url = $facebook->getLoginUrl(array(
                'scope' => 'email',
                'canvas' => 1
           ));
           $this->redirect($url);
        }

        public function facebook_callback(){
           $user = $facebook->getUser();

           if($user){
                $data = $this->User->facebook_sign_up($user);
           }

           if(isset($data['name'])){
                $this->Auth->login($data);
           } else{
                $this->Session->setFlash(__('既にその名前は使用されています'));
                $this->redirect(array('action' => 'login'));
           }

           $this->redirect($this->Auth->loginRedirect);
        }

        public function logout(){
           $this->Auth->logout();
           $this->Session->destroy();
           $this->Session->setFlash(__('ログアウトしました'));
           $this->redirect(array('action' => 'login'));
        }

        public function detail(){
        }
    }
