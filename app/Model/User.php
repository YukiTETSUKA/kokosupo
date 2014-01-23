<?php
    class User extends Model{
        public $name = 'User';

        var $validate = array(
            'name' => array(
                'rule'    => 'isUnique',
                'message' => '重複です',
            ),
            'password' => array(
                'rule' => 'alphaNumeric',
                'message' => 'パスワードとして不適切です',
            ),
        );

        public function auth_login($data){
        }

        public function twitter_sign_up($token){
            if(is_string($token)){
                return;
            }

            $data['name']        = $token['screen_name'];
            $data['password']    = Security::hash($token['oauth_token']);
            $data['provider']    = 'twitter';
            $data['provider_id'] = $token['user_id'];

            if($this->validates()){
                if(!$this->save($data) && !$this->find('first', array('conditions' => array('provider' => $data['provider'], 'provider_id' => $data['provider_id'])))){
                    return;
                }
            }

            return $data;
        }

        public function facebook_sign_up($token){
            if(is_string($token)){
                return;
            }

            $user = $token->api('/me');

            $data['name']        = $user['username'];
            $data['password']    = Security::hash($user['username']);
            $data['provider']    = 'facebook';
            $data['provider_id'] = $user['id'];

            if($this->validates()){
                if(!$this->save($data) && !$this->find('first', array('conditions' => array('provider' => $data['provider'], 'provider_id' => $data['provider_id'])))){
                    return;
                }
            }
        }
        public function signinfb($token){
            //アクセストークンを正しく取得できなかった場合の処理
            //debug($token);
            if(is_string($token))return; //エラー
            $data['name'] = $token['name'];
            //$data['email'] = $token['email'];
            $data['password']    = Security::hash($token['name']);
            $data['provider'] = 'facebook';
            $data['provider_id'] = $token['id'];
            //バリデーションチェックでエラーがなければ、新規登録
            if($this->validates()){
                $this->save($data);
            }
            $data = $this->find('first', array('conditions' => array('provider_id'=>$data['provider_id'])));
            return $data; //ログイン情報
        }
                public function signin($token){
            //アクセストークンを正しく取得できなかった場合の処理
            if(is_string($token))return; //エラー
 
            $data['id'] = $token['user_id'];
            $data['username'] = $token['screen_name'];
            $data['password'] = Security::hash($token['oauth_token']);
            //$data['oauth_token'] = Security::hash($token['oauth_token']);
            //$data['oauth_token_secret'] = Security::hash($token['oauth_token_secret']);
 
            //バリデーションチェックでエラーがなければ、新規登録
            if($this->validates())$this->save($data);{
                return $data; //ログイン情報
            }
        }
    }
