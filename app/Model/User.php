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
    }
