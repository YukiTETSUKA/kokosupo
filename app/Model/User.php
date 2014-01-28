<?php
    class User extends Model{
        public $name = 'User';

        var $validate = array(
            'name' => array(
                'alphaNumeric' => array(
                     'rule'    => 'alphaNumeric',
                     'message' => '名前として不適切です',
                     'last'    => true,
                ),
                'minLength' => array(
                     'rule' => array('minLength', '4'),
                     'message' => '名前は4文字以上です',
                     'last'    => true,
                ),
                'maxLength' => array(
                     'rule' => array('maxLength', '20'),
                     'message' => '名前は20文字以下です',
                     'last'    => true,
                ),
                'isUnique' => array(
                     'rule'    => 'isUnique',
                     'message' => '重複です',
                ),
            ),
            'password' => array(
                'minLength' => array(
                     'rule' => array('minLength', '4'),
                     'message' => 'パスワードは4文字以上です',
                     'last'    => true,
                ),
                'maxLength' => array(
                     'rule' => array('maxLength', '20'),
                     'message' => 'パスワードは20文字以下です',
                     'last' => true,
                ),
            ),
        );

        public function auth_login($data){
            if($data['password'] == $data['pass_check']){
                if(!$this->findByName($data['name'])){ // ユーザ名が使用されているか
                    if($this->validates()){ // バリデーションのチェック
                        $user['name'] = $data['name'];
                        $user['password'] = AuthComponent::password($data['password']);
                        debug($user);
                        $this->set($user); // Modelへ値をセット
                        $this->create(); // Usersテーブルのレコードを作成
                        return ($this->save($user, false) ? false : '登録に失敗しました');
                    } else{
                        if(isset($this->validationErrors['name'][0])){
                            return $this->validationErrors['name'][0];
                        } else{
                            return $this->validationErrors['password'][0];
                        }
                    }
                } else{
                    return '既にそのユーザ名は使用されています．';
                }
            } else{
                return 'パスワードとパスワード(確認)が一致しませんでした';
            }
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

            return $data;
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
    }
