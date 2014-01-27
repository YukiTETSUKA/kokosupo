<?php
    //facebook認証
    App::import('Vendor','facebook',array('file' => 'facebook'.DS.'src'.DS.'facebook.php'));
     
    class FbconnectsController extends AppController {
        public $name = 'Fbconnects';
        public $uses = array('User');
        //public $layout = 'jqm';
        public $layout = 'kokosupo';
        public $helpers = array('Facebook.Facebook');
        public $components = array(
                    'DebugKit.Toolbar', 
                    'Auth' => array(  
                        'authenticate' => array(  
                            'Form' => array(  
                                'userModel'=>'User'
                            )  
                        ),  
                        'loginRedirect' => array('controller' => 'kokosupos', 'action' => 'index'),
                        'logoutRedirect' => array('controller' => 'kokosupos', 'action' => 'logout'),
                        'loginAction' => array('controller' => 'kokosupos', 'action' => 'index'),
                        'authError' => 'あなたのお名前とパスワードを入力して下さい。', 
                    ),  
                    'Facebook.Connect' => array('model' => 'Fbconnect')  
                );  
        public function beforeFilter(){//login処理の設定
                 $this->Auth->allow('index', 'facebook', 'fbpost','createFacebook');
                 $this->set('user',$this->Auth->user()); // ctpで$userを使えるようにする 。
                 if($this->request->is('mobile')){
                     //テーマをJqm、レイアウトをjqmに指定します。
                     $this->theme = 'Jqm';
                     $this->layout = 'jqm';
                 }
            }
        public function index(){}
     
        public function showdata(){//トップページ
            $facebook = $this->createFacebook(); //セッション切れ対策 (?)
            $myFbData = $this->Session->read('mydata');//facebookのデータ
            //$myFbData_kana = $this->Session->read('fbdata_kana'); //フリガナ
            //pr($myFbData_kana); //フリガナデータ表示
            //pr($myFbData);//表示
            //$this->fbpost("hello world");//facebookに投稿
        }
     
        public function facebook(){//facebookの認証処理部分
            $this->autoRender = false;
            $this->facebook = $this->createFacebook();
            $user = $this->facebook->getUser();//ユーザ情報取得
            if($user){//認証後
                $me = $this->facebook->api('/me','GET',array('locale'=>'ja_JP'));//ユーザ情報を日本語で取得
                $this->Session->write('mydata',$me);//fbデータをセッションに保存
                //フリガナを取得する．
                //$me_kana = $this->facebook->api('/fql?q=SELECT+first_name%2C+sort_first_name%2C+last_name%2C+sort_last_name%2Cname+FROM+user+WHERE+uid+%3D+'.$me['id'].'&locale=ja_JP');//ふりがな
                //if(!empty($me_kana)){//フリガナ設定をしているユーザのみ
                // mb_convert_variables('UTF-8', 'auto', $me_kana);
                // $this->Session->write('fbdata_kana',$me_kana);//フリガナデータをセッションに保存
            //}
                //debug($this->Session->read('mydata'));
                $data = $this->User->signinfb($this->Session->read('mydata'));
                debug($this->facebook->api('/me','GET',array('locale'=>'ja_JP')));
                if($this->Auth->login($data)){
                    return $this->redirect($this->Auth->redirect());
                }
            }else{//認証前
                $url = $this->facebook->getLoginUrl(array(
                'scope' => 'email,publish_stream,user_birthday'
                ,'canvas' => 1,'fbconnect' => 0));
                $this->redirect($url);
            }
        }
     
        private function createFacebook() {//appID, secretを記述
            return new Facebook(array(
                'appId' => '421784944615764',
                'secret' => '36d71a554ac28cb363ea3b316c771cd4'
            ));
        }
     
        public function fbpost($postData) {//facebookのwallにpostする処理
            $facebook = $this->createFacebook();
            $attachment = array(
                'access_token' => $facebook->getAccessToken(), //access_token入手
                'message' => $postData,
                'name' => "test",
                'link' => "http://twitter.com/live_in_swmt",
                'description' => "test",
            );
            $facebook->api('/me/feed', 'POST', $attachment);
        }
    }
?>