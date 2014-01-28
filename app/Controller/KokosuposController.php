<?php
    App::import('Vendor','facebook', array('file' => 'facebook'.DS.'src'.DS.'facebook.php')); //sdkのインポート

    class KokosuposController extends AppController{
        public $name = 'Kokosupos';
        public $layout = 'kokosupo';
        public $uses = array('User', 'Spot', 'Comment', 'Image', 'Supobijo');
        public $components = array(
            'DebugKit.Toolbar',
            'TwitterKit.Twitter',
            'Auth' => array(
                'authenticate'   => array(
                    'Form' => array(
                        'userModel' => 'User',
                        'fields'    => array(
                            'name' => 'name',
                            'password' => 'password',
                        ),
                    ),
                ),
                'loginRedirect'  => array('action' => 'index'),
                'logoutRedirect' => array('action' => 'login'),
                'loginAction'    => array('action' => 'login'),
                'authError'      => 'ログインしてください',
            )
        );

        public function beforeFilter(){
            $this->Auth->allow('login', 'logout', 'sign_up', 'twitter_login', 'twitter_callback', 'facebook_login', 'facebook_callback');
            $user = $this->Auth->user();
            //debug($user);
            $user['Kokosupo'] = $this->User->findByName($user['User']['name']);
            //$user['User'] = $user['Kokosupo'];
            $this->set('user', $user);
            if($this->request->is('mobile')){
                 //テーマをJqm、レイアウトをjqmに指定します。
                 $this->theme = 'Jqm';
                 $this->layout = 'jqm';
             }
            //debug($user);
            //debug($this->request);
        }

        public function index(){
            //debug($this->request);
            if($this->request->is('post')){
               $spots = $this->Spot->search($this->request->data['kokosupo']);
               $this->set('spots', $spots);
               if(isset($this->request->data['kokosupo']['keyword'])){
                   $this->set('keyword', htmlspecialchars($this->request->data['kokosupo']['keyword']));
               }
            } else{
               $this->set('spots', $this->Spot->find('all', array('order' => array('Spot.id' => 'desc'))));
            }
        }

        public function login(){
            //debug($this->request);
            if($this->request->is('post')){
                debug($this->request);
                if($this->Auth->login()){
                    //$this->Session->delete('Auth.redirect');
                    return $this->redirect($this->Auth->loginRedirect);
                } else{
                    $this->Session->setFlash(__('ユーザ名かパスワードが違います'), 'default', array(), 'auth');
                }
            }

            $url = "http://clip.eventcast.jp/api/v1/Search?Tag=岩手&Format=json&Sort=date&Order=desc";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            $res = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);

            $this->set('api', json_decode($res, true));
        }

        public function sign_up(){
            if($this->request->is('post')){ // POST送信
                // パスワードとパスワード(確認)が一致しているか
                // true: ユーザ情報を登録，false: 再入力を促す
                $massage = $this->User->auth_login($this->request->data['kokosupo']);
                //debug($massage);
                if($massage == false){
                    $this->Session->setFlash(__('登録完了'), 'default', array(), 'auth');
                    return $this->redirect(array('action' => 'login'));
                } else{
                    $this->Session->setFlash(__($massage), 'default', array(), 'auth');
                }
            }
        }

        public function twitter_login(){
            $this->set('url', $this->Twitter->getAuthenticateUrl(null, true));
            return $this->Redirect($this->Twitter->getAuthenticateUrl(null, true));
        }

        public function twitter_callback(){
           if(!$this->Twitter->isRequested()){
                $this->flash(__('invalid access.'), '/', 5);
                return $this->redirect($this->Auth->loginRedirect);
           }

           $this->Twitter->setTwitterSource('twitter');
           $token = $this->Twitter->getAccessToken();
           $user = $this->User->twitter_sign_up($token);
           $data = $this->User->findByName($user['name']);

           if(isset($data['User']['name'])){
               $data['User'] = $this->User->twitter_sign_up($token);

               if(isset($data['User']['name'])){
                    $this->Auth->login($data);
               } else{
                    $this->Session->setFlash(__('既にその名前は使用されています'));
               }
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
            $user     = $facebook->getUser();

            if($user){
                $data['Kokosupo'] = $this->User->facebook_sign_up($user);
                if(isset($data['Kokosupo']['name'])){
                    $this->Auth->login($data);
                    debug($data);
                    return $this->redirect($this->Auth->loginRedirect);
                } else{
                    $this->Session->setFlash(__('既にその名前は使用されています'), 'default', array(), 'auth');
                    debug($facebook);
                    debug($user);
                    debug($data);
                    //return $this->redirect(array('action' => 'login'));
                }
            } else{
               $url = $facebook->getLoginUrl(array(
                    'scope' => 'email',
                    'canvas' => 1
               ));
               return $this->redirect($url);
            }
        }

        public function facebook_callback(){
           $user = $facebook->getUser();

           if($user){
                $data = $this->User->facebook_sign_up($user);
           }

           if(isset($data['name'])){
                $this->Auth->login($data);
           } else{
                $this->Session->setFlash(__('既にその名前は使用されています'), 'default', array(), 'auth');
                return $this->redirect(array('action' => 'login'));
           }

           return $this->redirect($this->Auth->loginRedirect);
        }

        public function logout(){
           $this->Auth->logout();
           $this->Session->destroy();
           $this->Session->setFlash(__('ログアウトしました'), 'default', array(), 'auth');
           return $this->redirect(array('action' => 'login'));
        }

        public function register_spot(){
            if($this->request->is('post') && isset($this->request->data['kokosupo'])){
                $this->Spot->register($this->request->data['kokosupo']);
                return $this->redirect($this->Auth->loginRedirect);
            }
        }

        public function detail(){
            //debug($this->request);
            if(isset($this->request->data['kokosupo']['comment'])){ // コメント投稿
                $this->Comment->post($this->request->data['kokosupo']);
            } elseif(isset($this->request->data['kokosupo']['comment']) && $this->request->data['kokosupo']['comment'] == ''){
                $this->Session->setFlash(__('コメントを入力してください'));
            }

            if(isset($this->request->data['kokosupo']['image'])){ // 画像投稿
                if($this->Image->upload($this->request->data['kokosupo']['image'], $this->request->params['pass'][0])){
                    $this->Session->setFlash(__('アップロードに成功しました'));
                } else{
                    $this->Session->setFlash(__('アップロードに失敗しました'));
                }
            }

            if(isset($this->request->data['kokosupo']['bust'])){ // すぽびじょ投稿
                if($this->Supobijo->register($this->request->data['kokosupo'])){
                    $this->Session->setFlash(__('すぽびじょに登録しました'));
                } else{
                    $this->Session->setFlash(__('すぽびじょに登録できませんでした'));
                }
            }

            if(isset($this->request->params['pass'][0])){ // 不正アクセスははじく
                if($spot = $this->Spot->findById($this->request->params['pass'][0])){
                    $this->set('spot', $spot);
                } else{
                    $this->Session->setFlash(__('そのスポットは存在しません'), 'default', array(), 'auth');
                    return $this->redirect(array('action' => 'index'));
                }
            } else{
                $this->Session->setFlash(__('不正なアクセスです'), 'default', array(), 'auth');
                return $this->redirect(array('action' => 'index'));
            }

            if(isset($this->request->params['pass'][1])){
                $this->set('various', $this->request->params['pass'][1]);
            } else{
                $this->set('various', 'comment');
            }
        }

        public function edit(){
            if($this->request->is('post')){
                $this->Spot->save($this->request->data['kokosupo']);
                $this->Session->setFlash(__('スポット情報を更新しました'), 'default', array(), 'auth');

                return $this->redirect(array('action' => 'detail/' . $this->request->params['pass'][0]));
            }

            if(isset($this->request->params['pass'][0])){
                $spot = $this->Spot->findById($this->request->params['pass'][0]);
                //if($spot['User']['id'] == $user['User']['id']){
                    $this->set('spot', $spot);
                //} else{
                //    $this->Session->setFlash(__('不正なアクセスです'), 'default', array(), 'auth');
                //    $this->redirect(array('action' => 'index'));
                //}
            } else{
                $this->Session->setFlash(__('不正なアクセスです'), 'default', array(), 'auth');
                return $this->redirect(array('action' => 'index'));
            }
        }

        public function delete(){
            if($this->request->is('post') && isset($this->request->data['kokosupo']['delete'])){
                $this->Spot->delete($this->request->params['pass'][0]);
                $this->Session->setFlash(__('スポットを削除しました'), 'default', array(), 'auth');
                return $this->redirect(array('action' => 'index'));
            }

            if(!isset($this->request->params['pass'][0])){
                $this->Session->setFlash(__('不正なアクセスです'), 'default', array(), 'auth');
                return $this->redirect(array('action' => 'index'));
            }

            $this->set('spot_id', $this->request->params['pass'][0]);
        }
    }
